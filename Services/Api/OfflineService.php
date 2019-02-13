<?php
namespace Services\Api;

use Models\Article;
use Models\Articles_has_Categories;
use Models\Categories_has_Categories;
use Models\Category;
use Models\ModelBehavior;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithAccessControl;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;

/**
 * Class OfflineService
 *
 * @package Services\Api
 */
class OfflineService implements IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkServiceWithAccessControl {
	use ApiBehavior;
	use ModelBehavior;

	/**
	 * @return string
	 */
	public function AllowOrigin () {
		return '*';
	}

	/**
	 * @param QuarkDTO $request
	 *
	 * @return IQuarkIOProcessor
	 */
	public function Processor (QuarkDTO $request) {
		return new QuarkJSONIOProcessor();
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		if (!$this->AuthorizeDevice($request))
			return array('status' => 403);

		//TODO Check if current user have purchased OFFLINE Mod

		//-----------------------------------------------------------------------------------------
		//---------------------STEP 0: Define output variables-------------------------------------
		//-----------------------------------------------------------------------------------------
		/**
		 * @var QuarkCollection|Category[] $output_categories
		 * @var QuarkCollection|Article[] $output_articles
		 */
		$output_categories = new QuarkCollection(new Category());
		$output_articles = new QuarkCollection(new Article());

		//-----------------------------------------------------------------------------------------
		//---------------------STEP 1: Get all API Root Elements-----------------------------------
		//-----------------------------------------------------------------------------------------
		/**
		 * @var QuarkCollection|Category[] $categories
		 */
		$categories = QuarkModel::Find(new Category(), array('available_on_api' => true), array(
			QuarkModel::OPTION_SORT => array('id' => QuarkModel::SORT_ASC),
			QuarkModel::OPTION_FIELDS => array('id')
		));

		/**
		 * @var QuarkCollection|Category[] $articles
		 */
		$articles = QuarkModel::Find(new Article(), array('available_on_api' => true), array(
			QuarkModel::OPTION_SORT => array('id' => QuarkModel::SORT_ASC),
			QuarkModel::OPTION_FIELDS => array('id')
		));

		//-----------------------------------------------------------------------------------------
		//---------------------STEP 2: Get id's of those ROOT elements-----------------
		//-----------------------------------------------------------------------------------------
		$categories_ids = array();

		foreach ($categories as $category)
			$categories_ids[$category->id] = false;

		$articles_ids = array();

		foreach ($articles as $article)
			$articles_ids[$article->id] = false;

		//Clear memory from useless information
		unset($categories);
		unset($articles);
		unset($category);
		unset($article);
		//-----------------------------------------------------------------------------------------
		//---------------------STEP 3: Get All Related elements------------------------------------
		//-----------------------------------------------------------------------------------------
		$done = false;//will store state of iterative process, which will extract all related categories and articles

		while (!$done) {
			/**
			 * @var QuarkCollection|Categories_has_Categories[] $cc_links
			 * @var QuarkCollection|Articles_has_Categories[] $ca_links
			 * @var QuarkCollection|Category[] $categories
			 * @var QuarkCollection|Article[] $articles
			 * @var QuarkModel|Article $article
			 * @var QuarkModel|Category $category
			 * @var array $content_categories_ids
			 * @var array $content_articles_ids
			 */
			//-------------------------------------------------------------------------------------
			//-----------------STEP 3.1: Go Trough All Categories, which was listed previously-----
			//-------------------------------------------------------------------------------------
			foreach ($categories_ids as $category_id => $status) {
				if ($status == true)
					continue;

				//Get category in minimal form from DB, for getting his related articles and categories
				$category = QuarkModel::FindOneById(new Category(), $category_id);
				$category = $category != null ? $category : new QuarkModel(new Category());

				//Add in output container listed category
				$output_categories[] = $category;

				//---------------------Find Related items------------------------------------------
				//Get category's related child categories
				$cc_links = QuarkModel::Find(new Categories_has_Categories(), array('parent_id' => (string)$category->id), array(
					QuarkModel::OPTION_SORT => array('priority' => QuarkModel::SORT_DESC)
				));

				foreach ($cc_links as $link)
					if (!isset($categories_ids[$link->child_id1->value]))
						$categories_ids[$link->child_id1->value] = false;

				unset($cc_links);

				//Get category's related articles
				$ca_links =  QuarkModel::Find(new Articles_has_Categories(), array('category_id' => $category->id));

				foreach ($ca_links as $link)
					if (!isset($articles_ids[$link->article_id->value]))
						$articles_ids[$link->article_id->value] = false;

				unset($cc_links);

				//Get category's child categories, which appear in his content
				$content_categories_ids = $this->ContentCategoriesIDs($category->intro);

				foreach ($content_categories_ids as $id)
					if (!isset($categories_ids[$id]))
						$categories_ids[$id] = false;

				unset($content_categories_ids);
				//Get category's articles, which appear in his content
				$content_articles_ids = $this->ContentArticlesIDs($category->intro);

				foreach ($content_articles_ids as $id)
					if (!isset($articles_ids[$id]))
						$articles_ids[$id] = false;

				$categories_ids[$category_id] = true;

				unset($content_articles_ids);
				unset($category);
			}

			//-------------------------------------------------------------------------------------
			//-----------------STEP 3.2: Go trough all Articles, which was listed previously-------
			//-------------------------------------------------------------------------------------
			foreach ($articles_ids as $article_id => $status) {
				if ($status == true)
					continue;

				//Get category in minimal form from DB, for getting his related articles and categories
				$article = QuarkModel::FindOneById(new Article(), $article_id);
				$article = $article != null ? $article : new QuarkModel(new Article());

				//Add in output container listed category
				$output_articles[] = $article;

				//---------------------Find Related items------------------------------------------
				//Get category's child categories, which appear in his content
				$content_categories_ids = $this->ContentCategoriesIDs($article->txtfield);

				foreach ($content_categories_ids as $id)
					if (!isset($categories_ids[$id]))
						$categories_ids[$id] = false;

				unset($content_categories_ids);
				//Get category's articles, which appear in his content
				$content_articles_ids = $this->ContentArticlesIDs($article->txtfield);

				foreach ($content_articles_ids as $id)
					if (!isset($articles_ids[$id]))
						$articles_ids[$id] = false;

				$articles_ids[$article_id] = true;

				unset($content_articles_ids);
				unset($article);
			}
			//-------------------------------------------------------------------------------------
			//-----------------STEP 3.3: Ceck, if cycle is complete--------------------------------
			//-------------------------------------------------------------------------------------
			$done = true;
			//Here we go trough all founded items. If nearly 1 element was not completely discovered, cycle continue
			foreach ($categories_ids as $key => $value) {
				if ($value == false) {
					$done = false;
					break;
				}
			}

			if ($done == true) {
				foreach ($articles_ids as $key => $value) {
					if ($value == false) {
						$done = false;
						break;
					}
				}
			}
		}
		ksort($categories_ids);
		ksort($articles_ids);

		return array(
			'status' => 200,
			'categories' => array_keys($categories_ids),
			'articles' => array_keys($articles_ids),
			'count' => sizeof($categories_ids) + sizeof($articles_ids)
		);
	}
}
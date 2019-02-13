<?php
namespace Services\Admin\Article\Relation;

use Models\Article;
use Models\Articles_has_Categories;
use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;

/**
 * Class LinkService
 *
 * @package Services\Admin\Article\Relation
 */
class LinkService implements IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		$page = $request->page != '' ? $request->page : 0;
		$limit = $request->limit != '' ? $request->limit : 25;

		/**
		 * @var QuarkCollection|Article[] $articles
		 */
		$articles = QuarkModel::Find(new Article(), array(), array(
			QuarkModel::OPTION_LIMIT => $limit,
			QuarkModel::OPTION_SKIP => $limit * $page
		));

		/**
		 * @var QuarkModel|Articles_has_Categories $link
		 * @var QuarkModel|Category $category
		 */
		foreach ($articles as $article) {
			$category = QuarkModel::FindOneById(new Category(), $article->category_id);

			if ($category == null) {
				Quark::Log('Cannot find category:' . $article->category_id);
				continue;
			}

			$link = QuarkModel::FindOne(new Articles_has_Categories(), array(
				'article_id' => $article->id,
				'category_id' => $category->id
			));

			if ($link != null)
				continue;

			$link = new QuarkModel(new Articles_has_Categories());
			$link->article_id = $article;
			$link->category_id = $category;

			if (!$link->Create())
				Quark::Log('Cannot create link with article:' . $article->id . ' & category:' . $category->id);
		}

		return QuarkDTO::ForRedirect('/admin/article/list');
	}
}
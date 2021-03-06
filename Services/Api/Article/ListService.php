<?php
namespace Services\Api\Article;

use Models\Article;
use Models\Category;
use Quark\IQuarkGetService;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkServiceWithAccessControl;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Api\ApiBehavior;

/**
 * Class ListService
 *
 * @package Services\Api\Article
 */
class ListService implements IQuarkGetService, IQuarkServiceWithCustomProcessor, IQuarkServiceWithAccessControl {
	use ApiBehavior;

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
	public function Get (QuarkDTO $request, QuarkSession $session) {
		if (!$this->AuthorizeDevice($request))
			return array('status' => 403);

		/**
		 * @var QuarkCollection|Article[] $articles
		 */
		if (strlen($request->URI()->Route(3)) > 0) {
			/**
			 * @var QuarkModel|Category $category
			 */
			$category = QuarkModel::FindOneById(new Category(), $request->URI()->Route(3));

			if ($category == null)
				return array('status' => 400);

			$articles = $category->ApiArticles($category->Articles());
		}
		else {
			$articles = QuarkModel::Find(new Article(), array(
				'available_on_api' => true,
				'title' => array('$ne' => '')
			), array(
				QuarkModel::OPTION_SORT => array('id' => QuarkModel::SORT_ASC)
			));
		}

		return array(
			'status' => 200,
			'articles' => $articles->Extract()
		);
	}
}
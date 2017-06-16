<?php

namespace Services\Article;

use Models\Article;
use Models\Articles_has_Categories;
use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Behaviors\AuthorizationBehavior;

/**
 * Class LinkService
 *
 * @package Services\Articles
 */
class LinkService implements IQuarkServiceWithCustomProcessor, IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Article $article
		 * @var QuarkModel|Category $category
		 * @var QuarkModel|Articles_has_Categories $link
		 */
		$article = QuarkModel::FindOneById(new Article(), $request->Data()->child);
		if ($article == null) return array(
			'status' => 404
		);
		$category = QuarkModel::FindOneById(new Category(), $request->Data()->parent);
		if ($category == null) return array(
			'status' => 404
		);
		$link = QuarkModel::FindOne(new Articles_has_Categories(), array(
			'article_id' => $article->id,
			'category_id' => $category->id
		));
		if ($link != null) return array(
			'status' => 409
		);
		$link = new QuarkModel(new Articles_has_Categories(), array(
			'article_id' => $article,
			"category_id" => $category
		));
		if (!$link->Create()) return array(
			'status' => 409
		);

		return array(
			'status' => 200,
			'category' => $category->id
		);
	}

	/**
	 * @param QuarkDTO $request
	 *
	 * @return IQuarkIOProcessor
	 */
	public function Processor (QuarkDTO $request) {
		return new QuarkJSONIOProcessor();
	}
}
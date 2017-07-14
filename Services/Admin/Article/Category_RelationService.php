<?php

namespace Services\Admin\Article;

use Models\Article;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class Category_RelationService
 *
 * @package Services\Article
 */
class Category_RelationService implements IQuarkServiceWithCustomProcessor, IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Article $article
		 */
		$article = QuarkModel::FindOneById(new Article(), $request->URI()->Route(3));
		if ($article == null) return array(
			'status' => 404
		);

		return array(
			'status' => 200,
			'article' => $article->Extract(),
			'categories' => $article->Categories()
		);
	}
}
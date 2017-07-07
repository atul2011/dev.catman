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
 * Class IndexService
 *
 * @package Services\Articles
 */
class IndexService implements IQuarkGetService, IQuarkServiceWithCustomProcessor,IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return array(
			'status' => 200,
			'item' => QuarkModel::FindOneById(new Article(), $request->URI()->Route(2))->Extract(
				array(
					'id',
					'title'
				)
			)
		);
	}
}
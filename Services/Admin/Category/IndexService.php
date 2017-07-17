<?php

namespace Services\Admin\Category;

use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;

/**
 * Class IndexService
 *
 * @package Services\Categories
 */
class IndexService implements IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return array(
			'status' => 200,
			'item' => QuarkModel::FindOneById(new Category(), $request->URI()->Route(2))->Extract(
				array(
					'id',
					'title'
				)
			)
		);
	}
}
<?php

namespace Services\Admin\User;

use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\QuarkDTO;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\User\IndexView;

/**
 * Class IndexService
 *
 * @package Services\Admin
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
		return QuarkView::InLayout(new IndexView(), new QuarkPresenceControl());
	}
}
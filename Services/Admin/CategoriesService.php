<?php

namespace Services\Admin;

use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Behaviors\AuthorizationBehavior;
use Services\Behaviors\CustomProcessorBehavior;
use ViewModels\Admin\CategoriesView;

/**
 * Class CategoriesService
 *
 * @package Services\Admin
 */
class CategoriesService implements IQuarkGetService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return QuarkView
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new CategoriesView(), new QuarkPresenceControl());
	}
}
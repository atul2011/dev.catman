<?php
namespace ViewModels\Admin\Status;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewResource;
use Quark\QuarkModel;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Admin\ViewBehavior;

/**
 * Class AccessForbiddenView
 *
 * @package ViewModels\Admin\Status
 */
class AccessForbiddenView implements IQuarkViewModel, IQuarkViewModelWithComponents, IQuarkPresenceControlViewModel {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function PresenceMenuHeader () {
		// TODO: Implement PresenceMenuHeader() method.
	}

	/**
	 * @return string
	 */
	public function PresenceMenuSide () {
		// TODO: Implement PresenceMenuSide() method.
	}

	/**
	 * @param QuarkModel $user = null
	 *
	 * @return string
	 */
	public function PresenceUser (QuarkModel $user = null) {
		// TODO: Implement PresenceUser() method.
	}

	/**
	 * @return string
	 */
	public function PresenceTitle () {
		return 'Status: 403';
	}

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/Status/AccessForbidden';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../static/Admin/Status/AccessForbidden/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../static/Admin/Status/AccessForbidden/index.js';
	}
}
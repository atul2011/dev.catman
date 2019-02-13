<?php
namespace ViewModels\Admin\Status;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewResource;
use Quark\QuarkModel;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Admin\ViewBehavior;

/**
 * Class InternalServerErrorView
 *
 * @package ViewModels\Admin\Status
 */
class InternalServerErrorView implements IQuarkViewModel, IQuarkViewModelWithComponents, IQuarkPresenceControlViewModel {
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
		return 'Status: 500';
	}

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/Status/InternalServerError';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../static/Admin/Status/InternalServerError/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../static/Admin/Status/InternalServerError/index.js';
	}
}
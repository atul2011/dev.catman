<?php
namespace ViewModels\Admin\Status;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewResource;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Admin\ViewBehavior;

/**
 * Class NotFoundView
 *
 * @package ViewModels\Admin\Status
 */
class NotFoundView implements IQuarkViewModel, IQuarkViewModelWithComponents, IQuarkPresenceControlViewModel {
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
	 * @return string
	 */
	public function PresenceTitle () {
		return 'Status: 404';
	}

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/Status/NotFound';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../static/Admin/Status/NotFound/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../static/Admin/Status/NotFound/index.js';
	}
}
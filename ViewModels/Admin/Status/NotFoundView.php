<?php

namespace ViewModels\Admin\Status;
use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewResource;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Admin\ViewBehavior;

class NotFoundView implements IQuarkViewModel, IQuarkViewModelWithComponents, IQuarkPresenceControlViewModel {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function PresenceTitle () {
		return 'Page Not Found';
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
		return __DIR__ . '/../../../static/Admin/Status/CSS/NotFound.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../static/Admin/Status/JS/NotFound.js';
	}
}
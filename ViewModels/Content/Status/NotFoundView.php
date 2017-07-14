<?php

namespace ViewModels\Content\Status;
use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewResource;
use ViewModels\Content\ViewBehavior;

class NotFoundView implements IQuarkViewModel ,IQuarkViewModelWithCustomizableLayout ,IQuarkViewModelWithComponents {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Content/Status/NotFound';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../static/Content/Status/CSS/NotFound.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../static/Content/Status/JS/NotFound.js';
	}
}
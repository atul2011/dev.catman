<?php

namespace ViewModels\Content;
use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewResource;

class IndexView implements IQuarkViewModel ,IQuarkViewModelWithComponents ,IQuarkViewModelWithCustomizableLayout {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Content/Index';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../static/Content/CSS/Index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../static/Content/JS/Index.js';
	}
}
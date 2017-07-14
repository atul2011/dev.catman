<?php

namespace ViewModels\Content\News;
use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewResource;
use ViewModels\Content\ViewBehavior;

class IndexView implements IQuarkViewModel ,IQuarkViewModelWithCustomizableLayout,IQuarkViewModelWithComponents {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Content/News/Index';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../static/Content/News/CSS/Index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../static/Content/News/JS/Index.js';
	}
}
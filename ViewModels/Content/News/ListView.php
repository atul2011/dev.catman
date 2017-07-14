<?php
/**
 * Created by PhpStorm.
 * User: boagh
 * Date: 12.07.2017
 * Time: 12:02
 */

namespace ViewModels\Content\News;
use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewResource;
use ViewModels\Content\ViewBehavior;

class ListView implements IQuarkViewModel ,IQuarkViewModelWithCustomizableLayout,IQuarkViewModelWithComponents {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Content/News/List';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../static/Content/News/CSS/List.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../static/Content/News/JS/List.js';
	}
}
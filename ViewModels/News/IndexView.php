<?php
namespace ViewModels\News;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewModelWithResources;
use Quark\IQuarkViewResource;
use Quark\ViewResources\SimpleMDE\SimpleMDE;
use ViewModels\ViewBehavior;

/**
 * Class IndexView
 *
 * @package ViewModels\News
 */
class IndexView implements IQuarkViewModel, IQuarkViewModelWithCustomizableLayout, IQuarkViewModelWithComponents {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'News/Index';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../static/News/Index/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../static/News/Index/index.js';
	}
}
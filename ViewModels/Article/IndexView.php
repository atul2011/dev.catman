<?php
namespace ViewModels\Article;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewResource;
use ViewModels\ViewBehavior;

/**
 * Class IndexView
 *
 * @package ViewModels\Article
 */
class IndexView implements IQuarkViewModel ,IQuarkViewModelWithCustomizableLayout,IQuarkViewModelWithComponents {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Article/Index';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../static/Article/Index/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../static/Article/Index/index.js';
	}
}
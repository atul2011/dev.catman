<?php
namespace ViewModels\Category;

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
 * @package ViewModels\Category
 */
class IndexView implements IQuarkViewModel ,IQuarkViewModelWithCustomizableLayout,IQuarkViewModelWithComponents, IQuarkViewModelWithResources {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Category/Index';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../static/Category/Index/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../static/Category/Index/index.js';
	}

	/**
	 * @return IQuarkViewResource[]
	 */
	public function ViewResources () {
		return array(
			new SimpleMDE()
		);
	}
}
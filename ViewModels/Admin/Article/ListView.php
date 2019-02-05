<?php
namespace ViewModels\Admin\Article;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewResource;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Admin\Behaviors\ILoader;
use ViewModels\Admin\Behaviors\INavigationBar;
use ViewModels\Admin\ViewBehavior;

/**
 * Class ListView
 *
 * @package ViewModels\Admin\Article
 */
class ListView implements IQuarkViewModel , IQuarkPresenceControlViewModel , IQuarkViewModelWithComponents, IQuarkViewModelWithCustomizableLayout, INavigationBar, ILoader {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function PresenceTitle () {
		return 'Articles List';
	}

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/Article/List';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../static/Admin/Article/List/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../static/Admin/Article/List/index.js';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewLayoutStylesheet () {
		return __DIR__ . '/../../../static/Admin/Behaviors/List/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewLayoutController () {
		return __DIR__ . '/../../../static/Admin/Behaviors/List/index.js';
	}
}
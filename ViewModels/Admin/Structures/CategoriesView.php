<?php
namespace ViewModels\Admin\Structures;

use Models\Category;
use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewModelWithResources;
use Quark\IQuarkViewModelWithVariableProxy;
use Quark\IQuarkViewResource;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use Quark\ViewResources\TwitterBootstrap\TwitterBootstrap;
use ViewModels\Admin\Behaviors\ILoader;
use ViewModels\Admin\Behaviors\INavigationBar;
use ViewModels\Admin\ViewBehavior;
use ViewResources\NotifyJS;

/**
 * Class CategoriesView
 *
 * @package ViewModels\Admin\Structures
 */
class CategoriesView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents, IQuarkViewModelWithResources, ILoader, IQuarkViewModelWithCustomizableLayout, INavigationBar, IQuarkViewModelWithVariableProxy {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function PresenceTitle () {
		return 'Categories';
	}

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/Structures/Categories';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../static/Admin/Structures/Categories/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../static/Admin/Structures/Categories/index.js';
	}

	/**
	 * @return IQuarkViewResource[]
	 */
	public function ViewResources () {
		return array(
			new TwitterBootstrap(),
			new NotifyJS()
		);
	}

	/**
	 * @param $vars
	 *
	 * @return mixed
	 */
	public function ViewVariableProxy ($vars) {
		return array(
			'root_id' => Category::RootCategory() != null ? Category::RootCategory()->id : 0,
			'root_name' => Category::RootCategory() != null ? Category::RootCategory()->title : '>'
		);
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewLayoutStylesheet () {
		return __DIR__ . '/../../../static/Admin/List/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewLayoutController () {
		return __DIR__ . '/../../../static/Admin/List/index.js';
	}
}
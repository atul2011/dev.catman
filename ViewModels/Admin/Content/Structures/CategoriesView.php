<?php
namespace ViewModels\Admin\Content\Structures;

use Models\Category;
use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewModelWithResources;
use Quark\IQuarkViewModelWithVariableProxy;
use Quark\IQuarkViewResource;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use Quark\ViewResources\TwitterBootstrap\TwitterBootstrap;
use ViewModels\Admin\Content\Behaviors\IListView;
use ViewModels\Admin\Content\Behaviors\ILoader;
use ViewModels\Admin\Content\Behaviors\INavigationBar;
use ViewModels\Admin\ViewBehavior;

/**
 * Class CategoriesView
 *
 * @package ViewModels\Structures\Categories
 */
class CategoriesView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents, IQuarkViewModelWithResources,ILoader,IQuarkViewModelWithCustomizableLayout,INavigationBar,IListView, IQuarkViewModelWithVariableProxy {
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
		return 'Admin/Content/Structures/Categories';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../../static/Admin/Content/Structures/CSS/Categories.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../../static/Admin/Content/Structures/JS/Categories.js';
	}

	/**
	 * @return IQuarkViewResource[]
	 */
	public function ViewResources () {
		return array(
			new TwitterBootstrap()
		);
	}

	/**
	 * @param $vars
	 *
	 * @return mixed
	 */
	public function ViewVariableProxy ($vars) {
		return array(
			'root_id' => Category::RootCategory() != null ? Category::RootCategory()->id : 0
		);
	}
}
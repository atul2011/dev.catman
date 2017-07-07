<?php

namespace ViewModels\Admin\Content\Category;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewResource;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Admin\Content\Behaviors\IListView;
use ViewModels\Admin\Content\Behaviors\ILoader;
use ViewModels\Admin\Content\Behaviors\INavigationBar;
use ViewModels\Admin\ViewBehavior;

class ListView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents,IListView,IQuarkViewModelWithCustomizableLayout,INavigationBar,ILoader {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function PresenceTitle () {
		return 'Categories List';
	}

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/Content/Category/List';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../../static/Admin/Content/Category/CSS/List.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../../static/Admin/Content/Category/JS/List.js';
	}
}
<?php

namespace ViewModels\Admin\Content\Banner;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewResource;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Admin\Content\Behaviors\IListView;
use ViewModels\Admin\Content\Behaviors\ILoader;
use ViewModels\Admin\Content\Behaviors\INavigationBar;
use ViewModels\Admin\ViewBehavior;

class ListView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents, IQuarkViewModelWithCustomizableLayout, IListView,INavigationBar,ILoader {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function PresenceTitle () {
		return 'Banner List';
	}

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/Content/Banner/List';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../../static/Admin/Content/Banner/CSS/List.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../../static/Admin/Content/Banner/JS/List.js';
	}
}
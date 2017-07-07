<?php

namespace ViewModels\Admin\Content\Event;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewResource;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Admin\Content\Behaviors\IListView;
use ViewModels\Admin\Content\Behaviors\ILoader;
use ViewModels\Admin\Content\Behaviors\INavigationBar;
use ViewModels\Admin\ViewBehavior;

class ListView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents,IQuarkViewModelWithCustomizableLayout,IListView,INavigationBar,ILoader {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function PresenceTitle () {
		return 'Event List';
	}

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/Content/Event/List';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../../static/Admin/Content/Event/CSS/List.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../../static/Admin/Content/Event/JS/List.js';
	}
}
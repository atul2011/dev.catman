<?php

namespace ViewModels\Content\Event;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewResource;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Content\Behaviors\IListView;
<<<<<<< HEAD
use ViewModels\ViewBehavior;

class ListView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents,IQuarkViewModelWithCustomizableLayout,IListView {
=======
use ViewModels\Content\Behaviors\ILoader;
use ViewModels\Content\Behaviors\INavigationBar;
use ViewModels\ViewBehavior;

class ListView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents,IQuarkViewModelWithCustomizableLayout,IListView,INavigationBar,ILoader {
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
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
		return 'Content/Event/List';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../static/Content/Event/CSS/List.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../static/Content/Event/JS/List.js';
	}
}
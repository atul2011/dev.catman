<?php

namespace ViewModels\Content\Author;
use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewResource;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Content\Behaviors\IListView;
use ViewModels\Content\Behaviors\INavigationBar;
use ViewModels\ViewBehavior;

class ListView implements IQuarkViewModel  , IQuarkPresenceControlViewModel  , IQuarkViewModelWithComponents, IQuarkViewModelWithCustomizableLayout,IListView,INavigationBar {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function PresenceTitle () {
		return 'Authors List';
	}

	/**
	 * @return string
	 */
	public function View () {
		return 'Content/Author/List';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../static/Content/Author/CSS/List.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../static/Content/Author/JS/List.js';
	}
}
<?php

namespace ViewModels\Content\Article;
use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewResource;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Content\Behaviors\IListView;
use ViewModels\ViewBehavior;

class ListView implements IQuarkViewModel , IQuarkPresenceControlViewModel , IQuarkViewModelWithComponents, IQuarkViewModelWithCustomizableLayout,IListView {
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
		return 'Content/Article/List';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../static/Content/Article/CSS/List.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../static/Content/Article/JS/List.js';
	}
}
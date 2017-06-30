<?php

namespace ViewModels\Content\Structures;

<<<<<<< HEAD
use Middleware\Bootstrap\Bootstrap;
use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithResources;
use Quark\IQuarkViewResource;
use Quark\ViewResources\jQuery\jQueryCore;
use Quark\ViewResources\MediumEditor\MediumEditor;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use Quark\ViewResources\TwitterBootstrap\TwitterBootstrap;
=======
use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewModelWithResources;
use Quark\IQuarkViewResource;
use Quark\ViewResources\jQuery\jQueryCore;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use Quark\ViewResources\TwitterBootstrap\TwitterBootstrap;
use ViewModels\Content\Behaviors\IListView;
use ViewModels\Content\Behaviors\ILoader;
<<<<<<< HEAD:ViewModels/Admin/CategoriesView.php
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
=======
use ViewModels\Content\Behaviors\INavigationBar;
>>>>>>> 0c443798c3d3437785fe0ed756bac941c799f283:ViewModels/Content/Structures/CategoriesView.php
use ViewModels\ViewBehavior;

/**
 * Class CategoriesView
 *
 * @package ViewModels\Structures\Categories
 */
<<<<<<< HEAD:ViewModels/Admin/CategoriesView.php
<<<<<<< HEAD
class CategoriesView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents, IQuarkViewModelWithResources {
=======
class CategoriesView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents, IQuarkViewModelWithResources,ILoader,IQuarkViewModelWithCustomizableLayout {
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
=======
class CategoriesView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents, IQuarkViewModelWithResources,ILoader,IQuarkViewModelWithCustomizableLayout,INavigationBar,IListView {
>>>>>>> 0c443798c3d3437785fe0ed756bac941c799f283:ViewModels/Content/Structures/CategoriesView.php
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
		return 'Content/Structures/Categories';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../static/Content/CategoryStructure/style.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../static/Content/CategoryStructure/script.js';
	}

	/**
	 * @return IQuarkViewResource[]
	 */
	public function ViewResources () {
		return array(
			new jQueryCore(),
			new TwitterBootstrap()
		);
	}
}
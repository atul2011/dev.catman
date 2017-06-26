<?php

namespace ViewModels\Admin;

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
use ViewModels\Content\Behaviors\ILoader;
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
use ViewModels\ViewBehavior;

/**
 * Class CategoriesView
 *
 * @package ViewModels\Admin
 */
<<<<<<< HEAD
class CategoriesView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents, IQuarkViewModelWithResources {
=======
class CategoriesView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents, IQuarkViewModelWithResources,ILoader,IQuarkViewModelWithCustomizableLayout {
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
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
		return 'Admin/Categories';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../static/Admin/CategoryStructure/style.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../static/Admin/CategoryStructure/script.js';
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
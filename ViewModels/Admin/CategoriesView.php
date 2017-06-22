<?php

namespace ViewModels\Admin;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewModelWithResources;
use Quark\IQuarkViewResource;
use Quark\ViewResources\jQuery\jQueryCore;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use Quark\ViewResources\TwitterBootstrap\TwitterBootstrap;
use ViewModels\Content\Behaviors\ILoader;
use ViewModels\ViewBehavior;

/**
 * Class CategoriesView
 *
 * @package ViewModels\Admin
 */
class CategoriesView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents, IQuarkViewModelWithResources,ILoader,IQuarkViewModelWithCustomizableLayout {
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
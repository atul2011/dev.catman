<?php


namespace ViewModels\Admin\User;
use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewResource;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Content\Behaviors\IListView;
use ViewModels\Content\Behaviors\ILoader;
use ViewModels\Content\Behaviors\INavigationBar;
use ViewModels\ViewBehavior;

class ListView implements IQuarkViewModel ,IQuarkPresenceControlViewModel , IQuarkViewModelWithComponents , IQuarkViewModelWithCustomizableLayout ,IListView,INavigationBar,ILoader {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function PresenceTitle () {
		return  'User List';
	}

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/User/List';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../static/Admin/User/CSS/List.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../static/Admin/User/JS/List.js';
	}
}
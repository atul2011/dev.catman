<?php
namespace ViewModels\Admin\Token;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewResource;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Admin\Behaviors\ILoader;
use ViewModels\Admin\Behaviors\INavigationBar;
use ViewModels\Admin\ViewBehavior;

/**
 * Class ListView
 *
 * @package ViewModels\Admin\Token
 */
class ListView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents, IQuarkViewModelWithCustomizableLayout, INavigationBar, ILoader {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function PresenceTitle () {
		return 'Tokens List';
	}

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/Token/List';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../static/Admin/Token/List/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../static/Admin/Token/List/index.js';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewLayoutStylesheet () {
		return __DIR__ . '/../../../static/Admin/Behaviors/List/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewLayoutController () {
		return __DIR__ . '/../../../static/Admin/Behaviors/List/index.js';
	}
}
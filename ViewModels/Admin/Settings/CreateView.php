<?php
namespace ViewModels\Admin\Settings;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewResource;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Admin\ViewBehavior;

/**
 * Class CreateView
 *
 * @package ViewModels\Admin\Term
 */
class CreateView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents, IQuarkViewModelWithCustomizableLayout {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function PresenceTitle () {
		return 'Settings Form';
	}

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/Settings/Create';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../static/Admin/Settings/Create/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../static/Admin/Settings/Create/index.js';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewLayoutStylesheet () {
		return __DIR__ . '/../../../static/Admin/Behaviors/Form/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewLayoutController () {
		return __DIR__ . '/../../../static/Admin/Behaviors/Form/index.js';
	}
}

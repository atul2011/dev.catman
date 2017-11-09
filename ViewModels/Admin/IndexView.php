<?php
namespace ViewModels\Admin;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewResource;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;

/**
 * Class IndexView
 *
 * @package ViewModels\Admin
 */
class IndexView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents {
    use ViewBehavior;
    /**
     * @return string
     */
    public function View() {
        return 'Admin/Index';
    }
    /**
     * @return string
     */
    public function PresenceTitle() {
        return 'Dashboard';
    }

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../static/Admin/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../static/Admin/index.js';
	}
}
<?php
namespace ViewModels\Admin\User;

use Quark\IQuarkViewModel;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Admin\ViewBehavior;

/**
 * Class IndexView
 *
 * @package ViewModels\Admin
 */
class IndexView implements IQuarkViewModel, IQuarkPresenceControlViewModel {
    use ViewBehavior;
    /**
     * @return string
     */
    public function View() {
        return 'Admin/User/Index';
    }
    /**
     * @return string
     */
    public function PresenceTitle() {
        return 'Dashboard';
    }
}
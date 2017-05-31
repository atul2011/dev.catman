<?php
namespace ViewModels\Admin;

use Quark\IQuarkViewModel;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\ViewBehavior;

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
        return 'Admin/Index';
    }
    /**
     * @return string
     */
    public function PresenceTitle() {
        return 'Dashboard';
    }




}
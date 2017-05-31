<?php
namespace ViewModels;


use Quark\QuarkModel;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControlComponent;

trait ViewBehavior
{
use QuarkPresenceControlComponent;
    /**
     * @return string
     */
    public function PresenceOverlaidContainer() {
        // TODO: Implement PresenceOverlaidContainer() method.
    }

    /**
     * @return string
     */
    public function PresenceLogo()  {
        return 'Home';
    }

    /**
     * @return string
     */
    public function PresenceMenuHeader()  {
        return $this->MenuHeaderWidget(array(
                $this->MenuWidgetItem('/',' statistic','fa-area-chart')
            )) . $this->SearchWidget('/articles/link','POST','search','');
    }

    /**
     * @return string
     */
    public function PresenceMenuSide() {
        return $this->MenuSideWidget(array(
            $this->MenuWidgetItem('/admin/','Dashboard','fa-bars')
            ,$this->MenuWidgetItem('/admin/categories','Categories','fa-align-left ')
//            ,$this->MenuWidgetItem('/admin/addon','Addon','fa-align-left ')
        ));
    }

    /**
     * @param QuarkModel $user = null
     *
     * @return string
     */
    public function PresenceUser(QuarkModel $user = null) {
        // TODO: Implement PresenceUser() method.
    }
}
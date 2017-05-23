<?php
namespace ViewModels;

use Quark\IQuarkViewModel;

class IndexView implements IQuarkViewModel
{
    /**
     * @return string
     */
    public function View() {
        return 'Index';
    }
}
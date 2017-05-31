<?php
namespace Services\Admin;


use Quark\IQuarkGetService;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use ViewModels\Admin\IndexView;

/**
 * Class IndexService
 * @package Services\Admin
 */
class IndexService implements IQuarkGetService ,IQuarkServiceWithCustomProcessor {
    /**
     * @param QuarkDTO $request
     * @param QuarkSession $session
     *
     * @return mixed
     */
    public function Get(QuarkDTO $request, QuarkSession $session) {
        return QuarkView::InLayout(new IndexView(),new QuarkPresenceControl());
    }

    /**
     * @param QuarkDTO $request
     *
     * @return IQuarkIOProcessor
     */
    public function Processor(QuarkDTO $request)  {
        return new QuarkJSONIOProcessor();
    }

}
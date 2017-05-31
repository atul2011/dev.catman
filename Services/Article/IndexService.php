<?php
namespace Services\Article;

use Models\Article;
use Quark\IQuarkGetService;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;

/**
 * Class IndexService
 *
 * @package Services\Articles
 */
class IndexService implements IQuarkGetService ,IQuarkServiceWithCustomProcessor {
    /**
     * @param QuarkDTO $request
     * @param QuarkSession $session
     *
     * @return mixed
     */
    public function Get(QuarkDTO $request, QuarkSession $session) {
        return array(
            'status' => 200,
            'item' =>QuarkModel::FindOneById(new Article(),$request->URI()->Route(1))->Extract(
                array(
                    'id',
                    'title'
                )
            )
        );
    }

    /**
     * @param QuarkDTO $request
     *
     * @return IQuarkIOProcessor
     */
    public function Processor(QuarkDTO $request) {
        return new QuarkJSONIOProcessor();
    }
}
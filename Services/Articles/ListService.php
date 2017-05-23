<?php
namespace Services\Articles;

use Models\Article;
use Quark\IQuarkGetService;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;

class ListService implements IQuarkServiceWithCustomProcessor,IQuarkGetService {
    /**
     * @param QuarkDTO $request
     * @param QuarkSession $session
     *
     * @return mixed
     */
    public function Get(QuarkDTO $request, QuarkSession $session) {
        /**
         * @var QuarkModel|Article $article
         */
        $article = QuarkModel::FindOneById(new Article(),$request->URI()->Route(2));
        if($article == null) return array(
            'status' => 404
        );
        return array(
            'status' => 200,
            'article' => $article->Extract(),
            'categories' => $article->Categories()->Extract()
        );
    }

    /**
     * @param QuarkDTO $request
     *
     * @return IQuarkIOProcessor
     */
    public function Processor(QuarkDTO $request)    {
        return new QuarkJSONIOProcessor();
    }

}
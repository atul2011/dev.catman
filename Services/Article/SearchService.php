<?php
namespace Services\Article;

use Models\Article;
use Quark\IQuarkGetService;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\Quark;

class SearchService implements IQuarkGetService, IQuarkServiceWithCustomProcessor{
    /**
     * @param QuarkDTO $request
     * @param QuarkSession $session
     *
     * @return mixed
     */
    public function Get(QuarkDTO $request, QuarkSession $session){
        /**
         * @var QuarkCollection|Article[] $articles
         */
        $articles = QuarkModel::Find(new Article());
        $out = new QuarkCollection(new Article());
        foreach ($articles as $article) {
            if(preg_match('#.*'.$request->title.'.*#Uis',$article->title)>0)
                $out[] =$article;
        }
        return array(
            'status' => 200,
            'response' => $out->Extract(array(
                    'id',
                    'title',
                    'release_date',
                    'txtfield'
                ),array(),array(
                    QuarkModel::OPTION_LIMIT =>100
                )
            ));
    }

    /**
     * @param QuarkDTO $request
     *
     * @return IQuarkIOProcessor
     */
    public function Processor(QuarkDTO $request){
        return new QuarkJSONIOProcessor();
    }

}
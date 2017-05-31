<?php
namespace Services\Category;

use Models\Category;
use Quark\IQuarkGetService;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;

class SearchService implements IQuarkServiceWithCustomProcessor, IQuarkGetService {
    /**
     * @param QuarkDTO $request
     * @param QuarkSession $session
     *
     * @return mixed
     */
    public function Get(QuarkDTO $request, QuarkSession $session) {
        /**
         * @var QuarkCollection|Category[] $categories
         */
        $categories = QuarkModel::Find(new Category());
        $out = new QuarkCollection(new Category());
        foreach ($categories as $category) {
            if(preg_match('#.*'.$request->title.'.*#Uis',$category->title)>0)
                $out[] =$category;
        }
        return array(
            'status' => 200,
            'response' => $out->Extract(array(
                    'id',
                    'title',
                    'sub',
                    'intro'
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
    public function Processor(QuarkDTO $request) {
        return new QuarkJSONIOProcessor();
    }

}
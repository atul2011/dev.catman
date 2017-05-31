<?php
namespace Services\Category;


use Models\Category;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;

/**
 * Class CreateService
 *
 * @package Services\Category
 */
class CreateService implements IQuarkServiceWithCustomProcessor,IQuarkPostService
{
    /**
     * @param QuarkDTO $request
     * @param QuarkSession $session
     *
     * @return mixed
     */
    public function Post(QuarkDTO $request, QuarkSession $session) {
        /**
         * @var QuarkModel|Category $category
         * @var QuarkCollection|Category $categories
         */
        //ceck if category is already exist
        $category = QuarkModel::FindOne(new Category(),array(
            'title' => $request->Data()->title
        ));
        if($category != null) return array(
            'status' => 403
        );

        $category = new QuarkModel(new Category(), $request->Data());
        if(!$category->Create()) return array(
            'status' => 400
        );

        return array(
            'status' => 200
        );
    }

    /**
     * @param QuarkDTO $request
     * @return IQuarkIOProcessor
     */
    public function Processor(QuarkDTO $request) {
        return new QuarkJSONIOProcessor();
    }

}
<?php
namespace Services\Category;


use Models\Category;
use Quark\IQuarkGetService;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;

/**
 * Class ArticlesService
 *
 * @package Services\Categories
 */
class ArticlesService implements IQuarkGetService,IQuarkServiceWithCustomProcessor{
    /**
     * @param QuarkDTO $request
     * @param QuarkSession $session
     *
     * @return mixed
     */
    public function Get(QuarkDTO $request, QuarkSession $session)
    {
        /**
         * @var QuarkModel|Category $category
         */
        $category = QuarkModel::FindOneById(new Category(),$request->URI()->Route(2));
        if($category == null) return array(
            'status' => 404
        );

        return array(
            'status' => 200,
            'category' => $category->Extract(),
            'articles' => $category->Articles()->Extract()
        );
    }

    /**
     * @param QuarkDTO $request
     *
     * @return IQuarkIOProcessor
     */
    public function Processor(QuarkDTO $request)
    {
        return new QuarkJSONIOProcessor();
    }

}
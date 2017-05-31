<?php
namespace Services\Article;

use Models\Article;
use Models\Articles_has_Categories;
use Models\Category;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\Quark;

/**
 * Class CreateService
 *
 * @package Services\Article
 */
class CreateService implements IQuarkPostService, IQuarkServiceWithCustomProcessor{
    /**
     * @param QuarkDTO $request
     * @param QuarkSession $session
     *
     * @return mixed
     */
    public function Post(QuarkDTO $request, QuarkSession $session) {
        /**
         * @var QuarkModel|Article $article
         * @var QuarkModel|Category $category
         * @var QuarkModel|Articles_has_Categories $article_category
         */
        //ceck if new article is already exist
        $article = QuarkModel::FindOne(new Article(),array(
            'title' => $request->Data()->title
        ));
        if($article != null) return array(
            'status' => 409
        );
        //create new article
        $article = new QuarkModel(new Article(),$request->Data());
        if(!$article->Create())return array(
            'status' => 409
        );

        return array(
            'status' =>200
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
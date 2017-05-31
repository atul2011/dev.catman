<?php
namespace Services\Article;

use Models\Article;
use Models\Articles_has_Categories;
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
 * Class DeleteService
 *
 * @package Services\Articles
 */
class DeleteService implements IQuarkPostService, IQuarkServiceWithCustomProcessor{
    /**
     * @param QuarkDTO $request
     * @param QuarkSession $session
     *
     * @return mixed
     */
    public function Post(QuarkDTO $request, QuarkSession $session) {
        /**
         * @var QuarkModel|Article $article
         * @var QuarkModel|Articles_has_Categories $article_links
         */
        $id = $request->URI()->Route(2);
        $article = QuarkModel::FindOneById(new Article(), $id);
//        $article_links = QuarkModel::Find(new Articles_has_Categories(), array(
//            'article_id' => $id
//        ));
        $query = array();

//        if ($article_links !== null ) {
//            if (!$article_links->Remove())
//                $query['status 1'] = '409';
//            $query['status 1'] = '200';
//            $query["cat_id 1 " . $article_links->article_id->id] = $article_links->article_id->id;
//        }
        if ($article !== null) {
            if (!$article->Remove())
                $query['status 2'] = '409';
            $query['status 2'] = '200';
            $query["cat_id 2 " . $article->id] = $article->id;
        }
        Quark::Trace($query);
        return $query;
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
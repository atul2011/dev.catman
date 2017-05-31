<?php
namespace Services\Category;

use Models\Articles_has_Categories;
use Models\Categories_has_Categories;
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

class DeleteService implements IQuarkPostService, IQuarkServiceWithCustomProcessor {
    /**
     * @param QuarkDTO $request
     * @param QuarkSession $session
     *
     * @return mixed
     */
    public function Post(QuarkDTO $request, QuarkSession $session) {
        /**
         * @var QuarkModel|Category $category
         * @var QuarkCollection|Categories_has_Categories[] $category_parent_links
         * @var QuarkCollection|Categories_has_Categories[] $category_child_links
         * @var QuarkCollection|Articles_has_Categories[] $article_links
          */
        $id = $request->URI()->Route(2);
        $category = QuarkModel::FindOneById(new Category(),$id);
        $category_parent_links = QuarkModel::Find(new Categories_has_Categories(),array(
            'parent_id' => $id
        ));
        $category_child_links = QuarkModel::Find(new Categories_has_Categories(),array(
            'child_id1' => $id
        ));
        $article_links = QuarkModel::Find(new Articles_has_Categories(),array(
            'category_id' => $id
        ));
        $query = array();

        if ($category_parent_links->Count() > 0)
            foreach ($category_parent_links as $link) {
                if (!$link->Remove())
                    $query['status 1'] = '409';
                $query['status 1'] = '200';
                $query["cat_id 1 " . $link->parent_id->id] = $link->parent_id->id;
            }

        if ($category_child_links->Count() > 0)
            foreach ($category_child_links as $link) {
                if (!$link->Remove())
                    $query['status 2'] = '409';
                $query['status 2'] = '200';
                $query["cat_id 2 " . $link->child_id1->id] = $link->child_id1->id;
            }

        if ($article_links->Count() > 0)
            foreach ($article_links as $link) {
                if (!$link->Remove())
                    $query['status 3'] = '409';
                $query['status 3'] = '200';
                $query["cat_id 3 " . $link->category_id->id] = $link->category_id->id;
            }

        if ($category !== null) {
            if (!$category->Remove())
                $query['status 4'] = '409';
            $query['status 4'] = '200';
            $query["cat_id 4 " . $category->id] = $category->id;
        }
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
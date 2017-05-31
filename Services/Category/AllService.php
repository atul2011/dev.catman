<?php
namespace Services\Category;

use Models\Categories_has_Categories;
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

/**
 * Class AllService
 *
 * @package Services\Categories
 */
class AllService implements IQuarkGetService, IQuarkServiceWithCustomProcessor{
    /**
     * @param QuarkDTO $request
     * @param QuarkSession $session
     *
     * @return mixed
     */
    public function Get(QuarkDTO $request, QuarkSession $session) {
        /**
         * @var QuarkCollection|Category[] $category
         * @var QuarkCollection|Categories_has_Categories[] $status
         */
        $category = QuarkModel::Find(new Category(), array(), array(
            QuarkModel::OPTION_LIMIT => 50
        ));
        $orfans = new QuarkCollection(new Category());

        //define variables that we will get from page.if not we will define default values
        $model='category';
        $orfan = false;
        if (isset($request->Data()->orfan)) $orfan = $request->Data()->orfan;
        if (isset($request->Data()->model)) $model = $request->Data()->model;

        //if is another model, go out
        if ( $model !== 'none' && $model !== 'category') {
            return array(
                'status' => 200,
                'response' => null
            );
            //if is roght model and want orfans, we give orfans
        }else if ($orfan === 'true' && $model === 'category') {
            foreach ($category as $item) {
                $status = QuarkModel::Count(new Categories_has_Categories(), array(
                    'child_id1' => $item->id
                ));
                if ($status == 0) $orfans[] = $item;
            }
            //if is not another model, and do not want orfans, we not gice orfans
        } else if ($orfan === 'false' && $model === 'none' || $model === 'category'){
            $orfans = $category;
        }
        return array(
            'status' => 200,
            'response' => $orfans->Extract(array(
                    'id',
                    'title',
                    'sub',
                    'intro'
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
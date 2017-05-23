<?php
namespace Models;

use Quark\IQuarkLinkedModel;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithCustomCollectionName;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkModelWithDefaultExtract;
use Quark\IQuarkStrongModel;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkModel;

/**
 * Class Category
 *
 * @property int $id
 * @property string $title
 * @property string $note
 * @property string $intro
 * @property string $sub
 * @property int    $priority
 * @property string $keywords
 * @property string $description
 *
 * @package Models
 */
class Category implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider,IQuarkModelWithCustomCollectionName ,IQuarkModelWithBeforeExtract, IQuarkModelWithDefaultExtract, IQuarkLinkedModel {
    /**
     * @return mixed
     */
    public function Fields() {
        return array(
            'id' => 0,
            'title' => '',
            'note' => '',
            'intro' => '',
            'sub' => '',
            'priority' =>0,
            'keywords' => '',
            'description' => ''
        );
    }

    /**
     * @return mixed
     */
    public function CollectionName() {
       return 'categories';
    }

    /**
     * @return mixed
     */
    public function Rules() {
        // TODO: Implement Rules() method.
    }

    /**
     * @return mixed
     */
    public function DataProvider() {
        return MP_DATA;
    }

    /**
     * @param array $fields
     * @param bool $weak
     *
     * @return mixed
     */
    public function BeforeExtract($fields, $weak) {
        $this->id = (string)$this->id;
        $this->priority = (string)$this->priority;
    }

    /**
     * @param array $fields
     * @param bool $weak
     *
     * @return mixed
     */
    public function DefaultExtract($fields, $weak) {
        if($fields != null) return $fields;

        return array(
            'id',
            'title',
            'note',
            'intro',
            'sub',
            'priority',
            'keywords',
            'description'
        );
    }

    /**
     * @param $raw
     *
     * @return mixed
     */
    public function Link($raw) {
        return QuarkModel::FindOneById(new Category(), $raw);
    }

    /**
     * @return mixed
     */
    public function Unlink() {
        return (string)$this->id;
    }

    /**
     * @param int $limit
     * @param int $offset
     *
     * @return QuarkCollection|Category[]
     */
    public function Categories($limit = 10, $offset = 0){
        /**
         * @var QuarkCollection|Categories_has_Categories[] $links
         */
        $links = QuarkModel::Find(new Categories_has_Categories(),array(
            'parent_id' => $this->id
        ),array(
            QuarkModel::OPTION_LIMIT => $limit,
            QuarkModel::OPTION_SKIP => $offset
        ));

        $out = new QuarkCollection(new Category());
        foreach ($links as $item){
            $out[] = $item->child_id1;
        }

        return $out;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return QuarkCollection|Article[]
     */
    public function Articles($limit = 10, $offset = 0){
       /**
        * @var QuarkCollection|Articles_has_Categories[] $links
        */
       $links = QuarkModel::Find(new Articles_has_Categories(),array(
           'category_id' => $this->id
       ),array(
           QuarkModel::OPTION_LIMIT => $limit,
           QuarkModel::OPTION_SKIP => $offset
       ));

       $out = new QuarkCollection(new Article());
       foreach ($links as $item){
           $out[]= $item->article_id;
       }
       return $out;
    }

}
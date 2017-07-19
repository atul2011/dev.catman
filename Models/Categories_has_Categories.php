<?php
namespace Models;

use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithCustomCollectionName;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkModelWithDefaultExtract;
use Quark\IQuarkStrongModel;
use Quark\QuarkModel;

/**
 * Class Categories_has_Categories
 *
 * @property Category $parent_id
 * @property Category $child_id1
 * @property int  $priority
 *
 * @package AllModels
 */
class Categories_has_Categories implements IQuarkModel,IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithDefaultExtract, IQuarkModelWithBeforeExtract,IQuarkModelWithCustomCollectionName {
	/**
	 * @return string
	 */
	public function CollectionName () {
		return 'categories_has_categories';
	}

	/**
     * @return mixed
     */
    public function Fields() {
        return array(
            'parent_id' => new  Category(),
            'child_id1' => new  Category(),
            'priority' => null
        );
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
        return CM_DATA;
    }

    /**
     * @param array $fields
     * @param bool $weak
     *
     * @return mixed
     */
    public function BeforeExtract($fields, $weak) {
        $this->parent_id = (string)$this->parent_id->id;
        $this->child_id1 = (string)$this->child_id1->id;
        $this->priority = (string)$this->priority;
    }

    /**
     * @param array $fields
     * @param bool $weak
     * @return mixed
     */
    public function DefaultExtract($fields, $weak) {
        if($fields != null) return $fields;
        return array(
            'parent_id',
            'child_id1',
            'priority'
        );
    }

    /**
     * @return QuarkModel|Category
     */
    public function Parent(){
        return QuarkModel::FindOneById(new Category(),$this->parent_id);
    }

    /**
     * @return QuarkModel|Category
     */
    public function Child(){
        return QuarkModel::FindOneById(new Category(),$this->child_id1);
    }
}
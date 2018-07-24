<?php
namespace Models;

use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithCustomCollectionName;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkModelWithDefaultExtract;
use Quark\IQuarkStrongModel;
use Quark\QuarkCollection;
use Quark\QuarkLazyLink;
use Quark\QuarkModel;
use Quark\QuarkModelBehavior;

/**
 * Class Categories_has_Categories
 *
 * @property int $id
 * @property QuarkLazyLink|Category $parent_id
 * @property QuarkLazyLink|Category $child_id1
 * @property int $priority
 *
 * @package Models
 */
class Categories_has_Categories implements IQuarkModel,IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithDefaultExtract, IQuarkModelWithBeforeExtract,IQuarkModelWithCustomCollectionName {
	use QuarkModelBehavior;
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
            'id' => 0,
            'parent_id' => $this->LazyLink(new Category()),
            'child_id1' => $this->LazyLink(new Category()),
            'priority' => 0
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
        $this->priority = (string)$this->priority;
    }

    /**
     * @param array $fields
     * @param bool $weak
     * @return mixed
     */
    public function DefaultExtract($fields, $weak) {
        if ($fields != null)
            return $fields;

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
        return QuarkModel::FindOneById(new Category(), $this->parent_id->value);
    }

    /**
     * @return QuarkModel|Category
     */
    public function Child(){
        return QuarkModel::FindOneById(new Category(), $this->child_id1->value);
    }
}
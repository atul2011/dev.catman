<?php
namespace Models;

use Quark\IQuarkModel;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkModelWithDefaultExtract;
use Quark\IQuarkStrongModel;
use Quark\QuarkLazyLink;
use Quark\QuarkModelBehavior;

/**
 * Class Articles_has_Categories
 *
 * @property int $id
 * @property QuarkLazyLink|Article $article_id
 * @property QuarkLazyLink|Category $category_id
 * @property int $priority
 *
 * @package Models
 */
class Articles_has_Categories implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithDefaultExtract {
	use QuarkModelBehavior;
    /**
     * @return mixed
     */
    public function Fields() {
        return array(
            'id' => 0,
            'article_id' => $this->LazyLink(new Article()),
            'category_id' => $this->LazyLink(new Category()),
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
    public function DefaultExtract($fields, $weak)    {
        if($fields != null)
            return $fields;

        return array(
            'article_id',
            'category_id',
            'priority'
        );
    }
}
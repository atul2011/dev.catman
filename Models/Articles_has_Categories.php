<?php
namespace Models;

use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkModelWithDefaultExtract;
use Quark\IQuarkStrongModel;

/**
 * Class Articles_has_Categories
 *
 * @property Article $article_id
 * @property Category $category_id
 *
 * @package AllModels
 */
class Articles_has_Categories implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithBeforeExtract, IQuarkModelWithDefaultExtract {
    /**
     * @return mixed
     */
    public function Fields() {
        return array(
            'article_id' => new Article(),
            'category_id' => new Category()
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
        $this->article_id = (string)$this->article_id->id;
        $this->category_id = (string)$this->category_id->id;
    }

    /**
     * @param array $fields
     * @param bool $weak
     *
     * @return mixed
     */
    public function DefaultExtract($fields, $weak)    {
        if($fields != null) return $fields;

        return array(
            'article_id',
            'category_id'
        );
    }
}
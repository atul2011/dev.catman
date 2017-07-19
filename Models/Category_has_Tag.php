<?php

namespace Models;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkStrongModel;

/**
 * Class Category_has_Tag
 *
 * @property Tag $tag_id
 * @property Category $category_id
 *
 * @package Models
 */
class Category_has_Tag implements IQuarkModel ,IQuarkStrongModel ,IQuarkModelWithDataProvider ,IQuarkModelWithBeforeExtract {
	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'tag_id' => new Tag(),
			'category_id' => new Category()
		);
	}

	/**
	 * @return mixed
	 */
	public function Rules () {
		// TODO: Implement Rules() method.
	}

	/**
	 * @return string
	 */
	public function DataProvider () {
		return CM_DATA;
	}

	/**
	 * @param array $fields
	 * @param bool $weak
	 *
	 * @return mixed
	 */
	public function BeforeExtract ($fields, $weak) {
		$this->category_id = (string)$this->category_id->id;
		$this->tag_id = (string)$this->tag_id->id;
	}
}
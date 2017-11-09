<?php
namespace Models;

use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkStrongModel;
use Quark\QuarkLazyLink;
use Quark\QuarkModelBehavior;

/**
 * Class Category_has_Tag
 *
 * @property QuarkLazyLink|Tag $tag_id
 * @property QuarkLazyLink|Category $category_id
 *
 * @package Models
 */
class Category_has_Tag implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider ,IQuarkModelWithBeforeExtract {
	use QuarkModelBehavior;
	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'tag_id' => $this->LazyLink(new Tag()),
			'category_id' => $this->LazyLink(new Category())
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
<?php
namespace Models;

use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkStrongModel;
use Quark\Quark;
use Quark\QuarkLazyLink;
use Quark\QuarkModel;
use Quark\QuarkModelBehavior;

/**
 * Class Category_has_Tag
 *
 * @property int $id
 * @property QuarkLazyLink|Tag $tag_id
 * @property QuarkLazyLink|Category $category_id
 *
 * @package Models
 */
class Category_has_Tag implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithBeforeExtract {
	use QuarkModelBehavior;
	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id' => 0,
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
		$this->id = (string)$this->id;
		$this->tag_id = $this->tag_id->value;
		$this->category_id = $this->category_id->value;
	}
	/**
	 * @param QuarkModel|Category $category
	 * @param QuarkModel|Tag $tag
	 *
	 * @return QuarkModel|Category_has_Tag
	 */
	public static function GetLink (QuarkModel $category = null, QuarkModel $tag = null) {
		return QuarkModel::FindOne(new Category_has_Tag(), array(
			'category_id' => $category->id,
			'tag_id' => $tag->id
		));
	}
}
<?php
namespace Models;

use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkModelWithDefaultExtract;
use Quark\IQuarkStrongModel;
use Quark\QuarkLazyLink;
use Quark\QuarkModel;
use Quark\QuarkModelBehavior;

/**
 * Class Photo_has_Tag
 *
 * @property int $id
 * @property QuarkLazyLink|Photo $photo
 * @property QuarkLazyLink|Tag $tag
 *
 * @package Models
 */
class Photo_has_Tag implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithDefaultExtract, IQuarkModelWithBeforeExtract {
	use QuarkModelBehavior;

	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id' => 0,
			'photo' => $this->LazyLink(new Photo()),
			'tag' => $this->LazyLink(new Tag())
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
	 * @return array
	 */
	public function DefaultExtract ($fields, $weak) {
		if ($fields != null)
			return $fields;

		return array(
			'id',
			'photo',
			'tag'
		);
	}

	/**
	 * @param array $fields
	 * @param bool $weak
	 *
	 * @return mixed
	 */
	public function BeforeExtract ($fields, $weak) {
		$this->id = (string)$this->id;
		$this->tag = $this->tag->value;
		$this->photo = $this->photo->value;
	}
	/**
	 * @param QuarkModel|Photo $photo
	 * @param QuarkModel|Tag $tag
	 *
	 * @return QuarkModel|Photo_has_Tag
	 */
	public static function GetLink (QuarkModel $photo = null, QuarkModel $tag = null) {
		return QuarkModel::FindOne(new Photo_has_Tag(), array(
			'photo' => $photo->id,
			'tag' => $tag->id
		));
	}
}
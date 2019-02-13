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
 * Class Article_has_Photo
 *
 * @property int $id
 * @property QuarkLazyLink|Article $article
 * @property QuarkLazyLink|Photo $photo
 *
 * @package Models
 */
class Article_has_Photo implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithDefaultExtract, IQuarkModelWithBeforeExtract {
	use QuarkModelBehavior;
	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id' => 0,
			'article' => $this->LazyLink(new Article()),
			'photo' => $this->LazyLink(new Photo())
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
		$this->photo = $this->photo->value;
		$this->article = $this->article->value;
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
			'article',
			'photo'
		);
	}

	/**
	 * @param QuarkModel|Article $article
	 * @param QuarkModel|Photo $photo
	 *
	 * @return QuarkModel|Article_has_Photo
	 */
	public static function GetLink (QuarkModel $article = null, QuarkModel $photo = null) {
		return QuarkModel::FindOne(new Article_has_Photo(), array(
			'article' => $article->id,
			'photo' => $photo->id
		));
	}
}
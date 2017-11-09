<?php
namespace Models;

use Quark\IQuarkLinkedModel;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithCustomCollectionName;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkModelWithDefaultExtract;
use Quark\IQuarkNullableModel;
use Quark\IQuarkStrongModel;
use Quark\QuarkModel;
use Quark\QuarkModelBehavior;

/**
 * Class Author
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property string $keywords
 *
 * @package AllModels\Content
 */
class Author implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithBeforeExtract, IQuarkModelWithDefaultExtract, IQuarkModelWithDataProvider, IQuarkModelWithCustomCollectionName, IQuarkLinkedModel, IQuarkNullableModel {
	use QuarkModelBehavior;

	const TYPE_HUMAN = 'H';
	const TYPE_MASTER = 'M';

	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id' => 0,
			'name'=>'',
			'description'=>'',
			'type' => self::TYPE_HUMAN,
			'keywords'=> ''
		);
	}

	/**
	 * @return string
	 */
	public function CollectionName () {
		return 'authors';
	}

	/**
	 * @return mixed
	 */
	public function Rules () {
		return array(
			$this->LocalizedAssert(in_array($this->type, array(self::TYPE_HUMAN, self::TYPE_MASTER)), 'Catman.Validation.Author.UnsupportedType', 'type')
		);
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
	}

	/**
	 * @param array $fields
	 * @param bool $weak
	 *
	 * @return array
	 */
	public function DefaultExtract ($fields, $weak) {
		if (!$fields=== null)
			return $fields;

		return array(
			'id',
			'name',
			'description',
			'type',
			'keywords'
		);
	}

	/**
	 * @param $raw
	 *
	 * @return mixed
	 */
	public function Link ($raw) {
		return QuarkModel::FindOneById(new Author(), $raw);
	}

	/**
	 * @return mixed
	 */
	public function Unlink () {
		return $this->id;
	}
}
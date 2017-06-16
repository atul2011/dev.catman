<?php

namespace Models;
use Quark\IQuarkLinkedModel;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithCustomCollectionName;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkModelWithDefaultExtract;
use Quark\IQuarkStrongModel;
use Quark\QuarkModel;

/**
 * Class Author
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property string $keywords
 *
 * @package Models\Content
 */
class Author implements IQuarkModel ,IQuarkStrongModel ,IQuarkModelWithBeforeExtract ,IQuarkModelWithDefaultExtract ,IQuarkModelWithDataProvider,IQuarkModelWithCustomCollectionName,IQuarkLinkedModel {
	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id' => 0,
			'name'=>'',
			'description'=>'',
			'type' => '',
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
		// TODO: Implement Rules() method.
	}

	/**
	 * @return string
	 */
	public function DataProvider () {
		return MP_DATA;
	}

	/**
	 * @param array $fields
	 * @param bool $weak
	 *
	 * @return mixed
	 */
	public function BeforeExtract ($fields, $weak) {
//		$this->id=(string)$this->id;
	}

	/**
	 * @param array $fields
	 * @param bool $weak
	 *
	 * @return array
	 */
	public function DefaultExtract ($fields, $weak) {
		if(!$fields=== null) return $fields;
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
		return (string)$this->id;
	}
}
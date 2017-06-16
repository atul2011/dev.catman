<?php

namespace Models;
use Quark\IQuarkLinkedModel;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithCustomCollectionName;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkModelWithDefaultExtract;
use Quark\IQuarkStrongModel;
use Quark\QuarkDate;
use Quark\QuarkModel;

/**
 * Class Event
 *
 * @property int $id
 * @property string $name
 * @property QuarkDate $startdate
 *
 * @package Models\Content
 */
class Event implements IQuarkModel ,IQuarkStrongModel ,IQuarkModelWithDataProvider ,IQuarkModelWithDefaultExtract, IQuarkModelWithBeforeExtract,IQuarkModelWithCustomCollectionName,IQuarkLinkedModel {
	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id' => 0,
			'name' => '',
			'startdate' =>QuarkDate::GMT
		);
	}

	/**
	 * @return string
	 */
	public function CollectionName () {
		return 'events';
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
	 * @return array
	 */
	public function DefaultExtract ($fields, $weak) {
		if(!$fields === null) return $fields;
		return array(
			'id',
			'name',
			'startdate'
		);
	}

	/**
	 * @param array $fields
	 * @param bool $weak
	 *
	 * @return mixed
	 */
	public function BeforeExtract ($fields, $weak) {
//		$this->id = (string)$this->id;
	}

	/**
	 * @param $raw
	 *
	 * @return mixed
	 */
	public function Link ($raw) {
		return QuarkModel::FindOneById(new Event(),$raw);
	}

	/**
	 * @return mixed
	 */
	public function Unlink () {
		return (string)$this->id;
	}
}
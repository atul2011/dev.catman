<?php
namespace Models;

use Quark\IQuarkLinkedModel;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithCustomCollectionName;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkModelWithDefaultExtract;
use Quark\IQuarkNullableModel;
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
 * @package Models
 */
class Event implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithDefaultExtract, IQuarkModelWithCustomCollectionName, IQuarkLinkedModel, IQuarkNullableModel {
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
		return CM_DATA;
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

	/**
	 * @return QuarkModel|Event
	 */
	public static function DefaultEvent () {
		return QuarkModel::FindOne(new Event());
	}
}
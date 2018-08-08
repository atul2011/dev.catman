<?php
namespace Models;

use Quark\IQuarkLinkedModel;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkNullableModel;
use Quark\IQuarkStrongModel;
use Quark\QuarkDate;
use Quark\QuarkModel;

/**
 * Class Device
 *
 * @property int $id
 * @property string $device_id
 * @property string $device_type
 * @property QuarkDate $date
 *
 * @package Models
 */
class UserDevice implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkLinkedModel, IQuarkNullableModel {
	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id' => 0,
			'device_id' => '',
			'device_type' => '',
			'date' => QuarkDate::GMTNow()
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
	 * @param $raw
	 *
	 * @return mixed
	 */
	public function Link ($raw) {
		return QuarkModel::FindOneById(new UserDevice(), $raw);
	}

	/**
	 * @return mixed
	 */
	public function Unlink () {
		return (string)$this->id;
	}
}
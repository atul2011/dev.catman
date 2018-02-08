<?php
namespace Models;

use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkStrongModel;
use Quark\QuarkDate;

/**
 * Class Link
 *
 * @property int $id
 * @property string $title
 * @property string $link
 * @property QuarkDate $created
 *
 * @package Models
 */
class Link implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithBeforeExtract {
	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id'=> 0,
			'title' => '',
			'link' => '',
			'created' => QuarkDate::GMTNow('Y-m-d')
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
	}
}
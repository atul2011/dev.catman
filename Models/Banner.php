<?php

namespace Models;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkStrongModel;
use Quark\QuarkDate;
use Quark\QuarkFile;

/**
 * Class Banner
 *
 * @property int $id
 * @property QuarkFile $file
 * @property QuarkDate $create_date
 * @property boolean $active
 *
 * @package Models
 */
class Banner implements IQuarkModel ,IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithBeforeExtract {
	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id' => 0,
			'file' => new QuarkFile(),
			'create_date' =>  QuarkDate::GMTNow('Y-m-d'),
			'active' => 0
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
		$this->file = $this->file->WebLocation();
	}
}
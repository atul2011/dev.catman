<?php

namespace Models;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkStrongModel;
use Quark\QuarkDate;

/**
 * Class News
 *
 * @property int $id
 * @property string $title
 * @property string $type
 * @property string $text
 * @property QuarkDate $publish_date
 * @property string $link_url
 * @property string $link_text
 * @property User   $lastediteby_userid
 * @property QuarkDate $lastedited_date
 *
 * @package AllModels
 */
class News implements IQuarkModel ,IQuarkStrongModel ,IQuarkModelWithDataProvider ,IQuarkModelWithBeforeExtract {
	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id' => 0,
			'title' => '0',
			'type' => '',
			'text' => '',
			'publish_date' => QuarkDate::FromFormat('d/m/y'),
			'link_url' => '',
			'link_text' => '',
			'lastediteby_userid' => new User(),
			'lastedited_date' => QuarkDate::GMTNow('d/m/y')
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
		return MP_DATA;
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
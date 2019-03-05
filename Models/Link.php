<?php
namespace Models;

use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithBeforeSave;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkStrongModel;
use Quark\QuarkCollection;
use Quark\QuarkDate;
use Quark\QuarkModel;

/**
 * Class Link
 *
 * @property int $id
 * @property string $title
 * @property string $link
 * @property string $type
 * @property string $target_type
 * @property string $target_value
 * @property bool $master
 * @property QuarkDate $created
 * @property QuarkDate $updated
 *
 * @package Models
 */
class Link implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithBeforeExtract, IQuarkModelWithBeforeSave {
	const TYPE_INDEPENDENT = 'independent';
	const TYPE_RELATED = 'related';

	const TARGET_TYPE_CATEGORY = 'category';
	const TARGET_TYPE_ARTICLE = 'article';

	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id'=> 0,
			'title' => '',
			'link' => '',
			'type' => self::TYPE_INDEPENDENT,
			'target_type' => self::TARGET_TYPE_CATEGORY,
			'target_value' => '',
			'master' => false,
			'created' => QuarkDate::GMTNow('Y-m-d'),
			'updated' => QuarkDate::GMTNow('Y-m-d')
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
	 * @param $options
	 *
	 * @return mixed
	 */
	public function BeforeSave ($options) {
		$this->updated = QuarkDate::GMTNow(QuarkDate::FORMAT_ISO);
		if (strlen($this->target_type) > 0 && strlen($this->target_value) > 0)
			$this->type = self::TYPE_RELATED;
		else
			$this->type = self::TYPE_INDEPENDENT;
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

	/**
	 * @return QuarkCollection|Link[]
	 */
	public static function IndependentLinks () {
		return QuarkModel::Find(new Link(), array('type' => self::TYPE_INDEPENDENT), array(
			QuarkModel::OPTION_SORT => array('title' => QuarkModel::SORT_ASC)
		));
	}
}
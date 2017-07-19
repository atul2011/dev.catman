<?php

namespace Models;
use Quark\IQuarkLinkedModel;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkStrongModel;
use Quark\QuarkModel;

/**
 * Class Tag
 *
 * @property int $id
 * @property string $name
 *
 * @package Models
 */
class Tag implements IQuarkModel ,IQuarkStrongModel ,IQuarkModelWithDataProvider ,IQuarkModelWithBeforeExtract, IQuarkLinkedModel {
	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id' => 0,
			'name' => ''
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

	/**
	 * @param $raw
	 *
	 * @return mixed
	 */
	public function Link ($raw) {
		return QuarkModel::FindOneById(new Tag(),$raw);
	}

	/**
	 * @return mixed
	 */
	public function Unlink () {
		return (string)$this->id;
	}
}
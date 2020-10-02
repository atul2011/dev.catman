<?php
namespace Models;

use Quark\IQuarkModelWithBeforeCreate;
use Quark\IQuarkModelWithBeforeSave;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkStrongModel;
use Quark\QuarkCollection;
use Quark\QuarkDate;
use Quark\QuarkModel;
use Quark\QuarkModelBehavior;

/**
 * Class Term
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $first_letter
 * @property QuarkDate $created
 *
 * @package Models
 */
class Settings implements IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithBeforeCreate, IQuarkModelWithBeforeSave {
	use QuarkModelBehavior;

	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			$this->DataProviderPk(),
		    'setting_name' => '',
		    'setting_description' => '',
		    'setting_value' => ''
		   
		);
	}

	/**
	 * @return mixed
	 */
	public function Rules () {
		return array(
			$this->LocalizedAssert(strlen($this->setting_name) > 0, 'Catman.Validation.Settings.setting_name.Empty', 'title')
		);
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
	public function BeforeCreate ($options) {
		//$this->first_letter = mb_substr($this->title, 0, 1);
	}

	/**
	 * @param $options
	 *
	 * @return mixed
	 */
	public function BeforeSave ($options) {
		//$this->first_letter = mb_substr($this->title, 0, 1);
	}

	/**
	 * @return array
	 */
}

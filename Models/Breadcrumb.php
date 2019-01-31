<?php
namespace Models;

use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkStrongModel;
use Quark\QuarkModel;
use Quark\QuarkModelBehavior;

/**
 * Class Breadcrumb
 *
 * @property int $id
 * @property string $value
 * @property string $childes
 * @property string $user
 *
 * @package Models
 */
class Breadcrumb implements IQuarkStrongModel, IQuarkModelWithDataProvider {
	use QuarkModelBehavior;
	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			$this->DataProviderPk(),
		    'value' => '',
		    'childes' => '',
		    'user' => ''
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
	 * @param string $user
	 * @param int $master <> 0
	 * @param string $type = 'c'->category || 'a'->article
	 * @param int $id
	 *
	 * @return bool
	 */
	public static function Set ($user, $master = -1, $type = 'c', $id = 0) {
		/**
		 * @var QuarkModel|Breadcrumb $breadcrumb
		 */
		$breadcrumb = QuarkModel::FindOne(new Breadcrumb(), array('user' => $user));

		if ($breadcrumb == null) {
			$breadcrumb = new QuarkModel(new Breadcrumb());
			$breadcrumb->user = $user;
			$breadcrumb->Create();
		}

		if ($master > 0 && $breadcrumb->GetMasterId() != $master)
			$breadcrumb->value = 'm:' . $master;

		if ($id > 0 && !$breadcrumb->FindItem('p', $type, $id))
			$breadcrumb->value .= ';' . $type . ':' . $id;

		$breadcrumb->Save();

		return true;
	}

	/**
	 * @return int
	 */
	public function GetMasterId () {
		if (strlen($this->value) == 0)
			return 0;

		return (int)(explode(':', explode(';', $this->value)[0])[1]);
	}

	/**
	 * @param string $user
	 *
	 * @return QuarkModel|Breadcrumb $breadcrumb
	 */
	public static function Get ($user) {
		return QuarkModel::FindOne(new Breadcrumb(), array('user' => $user));
	}

	/**
	 * @param string $target = c => 'childes' | p => 'parents'
	 * @param string $type = 'c'-category || 'a'-article
	 * @param int $id
	 *
	 * @return bool
	 */
	public function FindItem ($target = 'p', $type = 'c', $id) {
		$target_value = $target == 'p' ? $this->value : $this->childes;
		$values = explode(';', $target_value);

		foreach ($values as $value) {
			if ($value == $type . ':' . $id)
				return true;
		}

		return false;
	}

	/**
	 * @param string $type
	 * @param int $id
	 */
	public function SetChild ($type = 'c', $id = 0) {
		$this->childes .= (strlen($this->childes) > 0 ? ';' : '');
		$this->childes .=  $type . ':' . $id;
	}
}
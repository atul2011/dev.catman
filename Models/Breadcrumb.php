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
	 * @param int $master
	 * @param int $category
	 * @param int $article
	 *
	 * @return bool
	 */
	public static function Set ($user, $master, $category = 0, $article = 0) {
		/**
		 * @var QuarkModel|Breadcrumb $breadcrumb
		 */
		$breadcrumb = QuarkModel::FindOne(new Breadcrumb(), array('user' => $user));

		if ($breadcrumb == null) {
			$breadcrumb = new QuarkModel(new Breadcrumb());
			$breadcrumb->user = $user;
			$breadcrumb->Create();
		}

		if ($breadcrumb->GetMasterId() != $master){
			$breadcrumb->value = 'm:' . $master;
		}
		else {
			if ($category > 0)
				$breadcrumb->value .= ';c:' . $category;

			if ($article > 0)
				$breadcrumb->value .= ';a:' . $article;
		}

		return $breadcrumb->Save();
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
	 * @param int $id
	 *
	 * @return bool
	 */
	public function FindParent ($id) {
		$values = explode(';', $this->value);

		foreach ($values as $value) {
			if (explode(':', $value)[1] == $id)
				return true;
		}

		return false;
	}
}
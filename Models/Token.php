<?php
namespace Models;

use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkModelWithDefaultExtract;
use Quark\IQuarkStrongModel;
use Quark\Quark;
use Quark\QuarkDate;
use Quark\QuarkModelBehavior;

/**
 * Class Token
 *
 * @property int $id
 * @property string $token
 * @property QuarkDate $created
 *
 * @package Models
 */
class Token implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithDefaultExtract, IQuarkModelWithBeforeExtract {
	use QuarkModelBehavior;

	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id' => 0,
			'token' => '',
			'created' => QuarkDate::GMTNow()
		);
	}

	/**
	 * @return mixed
	 */
	public function Rules () {
		return array(
			$this->LocalizedAssert($this->token != '', 'Catman.Validation.Token.EmptyToken', 'token')
		);
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
		$this->created = $this->created->Format('d/m/Y h:m:s');
	}

	/**
	 * @param array $fields
	 * @param bool $weak
	 *
	 * @return array
	 */
	public function DefaultExtract ($fields, $weak) {
		if (!$fields == null)
			return $fields;

		return array(
			'id',
		    'token',
		    'created'
		);
	}

	/**
	 * @return string
	 */
	public static function GenerateToken () {
		return sha1(Quark::GuID());
	}
}
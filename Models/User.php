<?php

namespace Models;

use Quark\IQuarkAuthorizableModel;
use Quark\IQuarkLinkedModel;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeCreate;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithCustomCollectionName;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkModelWithDefaultExtract;
use Quark\IQuarkStrongModel;
use Quark\QuarkKeyValuePair;
use Quark\QuarkModel;

/**
 * Class User
 *
 * @property int $id
 * @property string $login
 * @property string $name
 * @property string $pass
 * @property string $email
 * @property string $rights
 *
 * @package AllModels\Admin
 */
class User implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithCustomCollectionName, IQuarkModelWithBeforeExtract, IQuarkModelWithBeforeCreate, IQuarkModelWithDataProvider, IQuarkAuthorizableModel, IQuarkModelWithDefaultExtract,IQuarkLinkedModel {
	/**
	 * @return string
	 */
	public function CollectionName () {
		return 'users';
	}

	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id' => 0,
			'login' => '',
			'name' => '',
			'pass' => '',
			'email' => '',
			'rights' => ''
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
	public function BeforeCreate ($options) {
		$this->pass = self::Password($this->login, $this->pass);
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
	 * @param array $fields
	 * @param bool $weak
	 *
	 * @return array
	 */
	public function DefaultExtract ($fields, $weak) {
		if (!$fields === null)
			return $fields;

		return array(
			'id',
			'login',
			'name',
			'email',
			'rights'
		);
	}

	/**
	 * @param string $name
	 * @param $session
	 *
	 * @return mixed
	 */
	public function Session ($name, $session) {
		return QuarkModel::FindOneById(new User(), $session->id);
	}

	/**
	 * @param string $name
	 * @param $criteria
	 * @param int $lifetime (seconds)
	 *
	 * @return QuarkModel|IQuarkAuthorizableModel
	 */
	public function Login ($name, $criteria, $lifetime) {
		return QuarkModel::FindOne(new User(), array(
			'login' => $criteria->login,
			'pass' => self::Password($criteria->login, $criteria->pass)
		));
	}

	/**
	 * @param string $name
	 * @param QuarkKeyValuePair $id
	 *
	 * @return bool
	 */
	public function Logout ($name, QuarkKeyValuePair $id) {
		// TODO: Implement Logout() method.
	}

	/**
	 * @param string $login
	 * @param string $pass
	 *
	 * @return string
	 */
	public static function Password ($login, $pass) {
		//hasing the password
		return sha1($login . md5($login . $pass) . $pass);
	}

	/**
	 * @param $raw
	 *
	 * @return mixed
	 */
	public function Link ($raw) {
		return QuarkModel::FindOneById(new User(),$raw);
	}

	/**
	 * @return mixed
	 */
	public function Unlink () {
		return (string)$this->id;
	}
}
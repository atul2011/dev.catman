<?php
namespace Models;

use Quark\IQuarkModel;
use Quark\IQuarkModelWithAfterFind;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkStrongModel;
use Quark\IQuarkStrongModelWithRuntimeFields;
use Quark\QuarkDate;
use Quark\QuarkLocalizedString;
use Quark\QuarkModel;
use Quark\QuarkModelBehavior;

/**
 * Class Notification
 *
 * @property int $id
 * @property string $content
 * @property string $type
 * @property string $target
 * @property QuarkDate $created
 * @property UserDevice $device
 * @property bool $readed
 * @property bool $sent
 *
 * @property bool $read_origin
 *
 * @package Models
 */
class Notification implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkStrongModelWithRuntimeFields, IQuarkModelWithAfterFind {
	use QuarkModelBehavior;

	const PAYLOAD_TYPE_CATEGORY = 'category';
	const PAYLOAD_TYPE_ARTICLE = 'article';

	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id' => 0,
			'content' => '',
			'type' => self::PAYLOAD_TYPE_CATEGORY,
			'target' => '',
			'created' => QuarkDate::GMTNow(QuarkDate::FORMAT_ISO_FULL),
			'device' => new QuarkModel(new UserDevice()),
			'readed' => false,
			'sent' => false
		);
	}

	/**
	 * @return mixed
	 */
	public function RuntimeFields () {
		return array(
			'read_origin' => false
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
	 * @param $raw
	 * @param array $options
	 *
	 * @return mixed
	 */
	public function AfterFind ($raw, $options) {
		$this->read_origin = $this->readed;
	}
}
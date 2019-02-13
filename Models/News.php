<?php
namespace Models;

use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithCustomCollectionName;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkStrongModel;
use Quark\QuarkDate;
use Quark\QuarkLazyLink;
use Quark\QuarkModelBehavior;

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
 * @property QuarkLazyLink|User   $lastediteby_userid
 * @property QuarkDate $lastedited_date
 *
 * @package AllModels
 */
class News implements IQuarkModel ,IQuarkStrongModel ,IQuarkModelWithDataProvider ,IQuarkModelWithBeforeExtract,IQuarkModelWithCustomCollectionName {
	use QuarkModelBehavior;

	const TYPE_NEW_EVENT = 'N';
	const TYPE_NEW_MATERIAL = 'T';
	const TYPE_CUSTOM = 'C';

	/**
	 * @return string
	 */
	public function CollectionName () {
		return 'news';
	}

	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id' => 0,
			'title' => '0',
			'type' => self::TYPE_NEW_EVENT,
			'text' => '',
			'publish_date' => QuarkDate::FromFormat('Y-m-d'),
			'link_url' => '',
			'link_text' => '',
			'lastediteby_userid' => $this->LazyLink(new User()),
			'lastedited_date' => QuarkDate::GMTNow('Y-m-d')
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


	public function RevealAll () {
		if ($this->lastediteby_userid != null)
			$this->lastediteby_userid = $this->lastediteby_userid->Retrieve();
	}
}
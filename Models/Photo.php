<?php
namespace Models;

use Quark\IQuarkLinkedModel;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkModelWithDefaultExtract;
use Quark\IQuarkNullableModel;
use Quark\IQuarkStrongModel;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDate;
use Quark\QuarkFile;
use Quark\QuarkModel;

/**
 * Class Photo
 *
 * @property int $id
 * @property string $name
 * @property string $file_name
 * @property QuarkFile $file
 * @property QuarkDate $created
 *
 * @package Models
 */
class Photo implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithBeforeExtract, IQuarkModelWithDefaultExtract, IQuarkLinkedModel, IQuarkNullableModel {
	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id' => 0,
			'name' => Quark::GuID(),
			'file_name' => '',
			'file' => new QuarkFile(__DIR__ . '/../static/resources/img/add_new_photo.png'),
			'created' => QuarkDate::FromFormat('Y-m-d')
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
	 *
	 * @return mixed
	 */
	public function Link ($raw) {
		return QuarkModel::FindOneById(new Photo(), $raw);
	}

	/**
	 * @return mixed
	 */
	public function Unlink () {
		return (string)$this->id;
	}

	/**
	 * @param array $fields
	 * @param bool $weak
	 *
	 * @return mixed
	 */
	public function BeforeExtract ($fields, $weak) {
		$this->file = $this->file->WebLocation();
	}

	/**
	 * @param array $fields
	 * @param bool $weak
	 *
	 * @return array
	 */
	public function DefaultExtract ($fields, $weak) {
		if ($fields != null)
			return $fields;

		return array(
			'id',
			'name',
			'file_name',
			'file',
			'created'
		);
	}

	/**
	 * @return QuarkCollection|Tag[]
	 */
	public function Tags () {
		/**
		 * @var QuarkCollection|Photo_has_Tag $links
		 */
		$links = QuarkModel::Find(new Photo_has_Tag(), array('photo' => $this->id));

		$tags = new QuarkCollection(new Tag());

		foreach ($links as $link) {
			/**
			 * @var QuarkModel|Photo_has_Tag $link
			 */
			$tags[] = QuarkModel::FindOneById(new Tag(), $link->tag->value);
		}

		return $tags;
	}
}
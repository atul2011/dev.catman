<?php
namespace Models;

use Quark\IQuarkLinkedModel;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkStrongModel;
use Quark\QuarkCollection;
use Quark\QuarkModel;

/**
 * Class Tag
 *
 * @property int $id
 * @property string $name
 *
 * @package Models
 */
class Tag implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithBeforeExtract, IQuarkLinkedModel {
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
		return QuarkModel::FindOneById(new Tag(), $raw);
	}

	/**
	 * @return mixed
	 */
	public function Unlink () {
		return (string)$this->id;
	}

	/**
	 * @return QuarkCollection|Photo[]
	 */
	public function Photos () {
		/**
		 * @var QuarkCollection|Photo_has_Tag[] $links
		 */
		$links = QuarkModel::Find(new Photo_has_Tag(), array('tag' => $this->id));

		$photos = new QuarkCollection(new Photo());

		foreach ($links as $link)
			$photos[] = $link->photo->Retrieve();

		return $photos;
	}

	/**
	 * @return QuarkCollection|Article[]
	 */
	public function Articles () {
		/**
		 * @var QuarkCollection|Article_has_Tag[] $links
		 */
		$links = QuarkModel::Find(new Article_has_Tag(), array('tag' => $this->id));

		$articles = new QuarkCollection(new Article());

		foreach ($links as $link)
			$articles[] = $link->article_id->Retrieve();

		return $articles;
	}

	/**
	 * @return QuarkCollection|Category[]
	 */
	public function Categories () {
		/**
		 * @var QuarkCollection|Category_has_Tag[] $links
		 */
		$links = QuarkModel::Find(new Category_has_Tag(), array('tag' => $this->id));

		$categories = new QuarkCollection(new Category());

		foreach ($links as $link)
			$categories[] = $link->category_id->Retrieve();

		return $categories;
	}
}
<?php
namespace Models;

use Quark\IQuarkLinkedModel;
use Quark\IQuarkModelWithBeforeCreate;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkStrongModel;
use Quark\IQuarkStrongModelWithRuntimeFields;
use Quark\QuarkCollection;
use Quark\QuarkDate;
use Quark\QuarkLazyLink;
use Quark\QuarkModel;
use Quark\QuarkModelBehavior;

/**
 * Class CategoryGroup
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property QuarkLazyLink|Category $category
 * @property int $priority
 * @property QuarkDate $created
 *
 * @property QuarkCollection|CategoryGroupItem[] $items
 *
 * @package Models
 */
class CategoryGroup implements IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithBeforeExtract, IQuarkModelWithBeforeCreate, IQuarkLinkedModel, IQuarkStrongModelWithRuntimeFields {
	use QuarkModelBehavior;

	const TYPE_ARTICLE = 'article';
	const TYPE_CATEGORY = 'category';

	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id' => 0,
		    'title' => 'New Group',
		    'description' => '',
		    'category' => new QuarkLazyLink(new Category()),
		    'priority' => 1,
		    'created' => QuarkDate::GMTNow(QuarkDate::FORMAT_ISO)
		);
	}

	/**
	 * @return mixed
	 */
	public function RuntimeFields () {
		return array(
			'items' => new QuarkCollection(new CategoryGroupItem())
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
		$this->priority = $this->category->Groups()->Count() + 1;
	}

	/**
	 * @param array $fields
	 * @param bool $weak
	 *
	 * @return mixed
	 */
	public function BeforeExtract ($fields, $weak) {
		$this->category = $this->category->value;
		$this->items = $this->Items();
	}

	/**
	 * @param $raw
	 *
	 * @return mixed
	 */
	public function Link ($raw) {
		return QuarkModel::FindOne(new CategoryGroup(), $raw);
	}

	/**
	 * @return mixed
	 */
	public function Unlink () {
		return (string)$this->id;
	}

	/**
	 * @return QuarkCollection|CategoryGroupItem $items
	 */
	public function Items () {
		return QuarkModel::Find(new CategoryGroupItem(), array('category_group' => (string)$this->id));
	}
}
<?php
namespace Models;

use Quark\IQuarkLinkedModel;
use Quark\IQuarkModelWithBeforeCreate;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkStrongModel;
use Quark\IQuarkStrongModelWithRuntimeFields;
use Quark\Quark;
use Quark\QuarkDate;
use Quark\QuarkLazyLink;
use Quark\QuarkModel;
use Quark\QuarkModelBehavior;

/**
 * Class CategoryGroupItem
 *
 * @property int $id
 * @property CategoryGroup $category_group
 * @property QuarkLazyLink|Category $category
 * @property string $type
 * @property int $target
 * @property int $priority
 * @property QuarkDate $created
 *
 * @property string $title
 *
 * @package Models
 */
class CategoryGroupItem implements IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithBeforeExtract, IQuarkModelWithBeforeCreate, IQuarkStrongModelWithRuntimeFields, IQuarkLinkedModel {
	use QuarkModelBehavior;

	const TYPE_ARTICLE = 'article';
	const TYPE_CATEGORY = 'category';

	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			$this->DataProviderPk(),
		    'category_group' => new CategoryGroup(),
		    'category' => new QuarkLazyLink(new Category()),
		    'type' => self::TYPE_ARTICLE,
		    'target' => 0,
			'priority' => 1,
		    'created' => QuarkDate::GMTNow(QuarkDate::FORMAT_ISO)
		);
	}

	/**
	 * @return mixed
	 */
	public function RuntimeFields () {
		return array(
			'title' => ''
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
		$this->priority = $this->category_group->Items()->Count() + 1;
		$this->category = $this->category_group->category->Retrieve();
	}

	/**
	 * @param array $fields
	 * @param bool $weak
	 *
	 * @return mixed
	 */
	public function BeforeExtract ($fields, $weak) {
		$this->category_group = (string)$this->category_group->id;
		if ($this->type == self::TYPE_CATEGORY) {
			/**
			 * @var QuarkModel|Category $category
			 */
			$category = QuarkModel::FindOneById(new Category(), $this->target, array(
				QuarkModel::OPTION_FIELDS => array('id', 'title')
			));

			$this->title = $category->title;
		}
		else if ($this->type == self::TYPE_ARTICLE) {
			/**
			 * @var QuarkModel|Article $article
			 */
			$article = QuarkModel::FindOneById(new Article(), $this->target, array(
				QuarkModel::OPTION_FIELDS => array('id', 'title')
			));

			$this->title = $article->title;
		}

	}

	/**
	 * @param $raw
	 *
	 * @return mixed
	 */
	public function Link ($raw) {
		return QuarkModel::FindOneById(new CategoryGroupItem(), $raw);
	}

	/**
	 * @return mixed
	 */
	public function Unlink () {
		return (string)$this->id;
	}

	/**
	 * @return string
	 */
	public function Id () {
		return (string)$this->id;
	}
}
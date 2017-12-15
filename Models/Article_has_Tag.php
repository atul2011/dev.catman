<?php
namespace Models;

use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkStrongModel;
use Quark\QuarkLazyLink;
use Quark\QuarkModel;
use Quark\QuarkModelBehavior;

/**
 * Class Article_has_Tag
 *
 * @property int $id
 * @property QuarkLazyLink|Tag $tag_id
 * @property QuarkLazyLink|Article $article_id
 *
 * @package Models
 */
class Article_has_Tag implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithBeforeExtract{
	use QuarkModelBehavior;
	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id' => 0,
			'tag_id' => $this->LazyLink(new Tag()),
			'article_id' => $this->LazyLink(new Article())
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
		$this->tag_id = $this->tag_id->value;
		$this->article_id = $this->article_id->value;
	}

	/**
	 * @param QuarkModel|Article $article
	 * @param QuarkModel|Tag $tag
	 *
	 * @return QuarkModel|Article_has_Tag
	 */
	public static function GetLink (QuarkModel $article = null, QuarkModel $tag = null) {
		return QuarkModel::FindOne(new Article_has_Tag(), array(
			'article_id' => $article->id,
			'tag_id' => $tag->id
		));
	}
}
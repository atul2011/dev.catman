<?php

namespace Models;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeExtract;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkStrongModel;

/**
 * Class Article_has_Tag
 *
 * @property Tag $tag_id
 * @property Article $article_id
 *
 * @package Models
 */
class Article_has_Tag implements IQuarkModel ,IQuarkStrongModel ,IQuarkModelWithDataProvider ,IQuarkModelWithBeforeExtract {
	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'tag_id' => new Tag(),
			'article_id' => new Article()
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
		$this->article_id = (string)$this->article_id->id;
		$this->tag_id = (string)$this->tag_id->id;
	}


}
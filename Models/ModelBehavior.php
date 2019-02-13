<?php
namespace Models;

use Quark\QuarkCollection;
use Quark\QuarkModel;

/**
 * Class ModelBehavior
 *
 * @package Models
 */
trait ModelBehavior {
	/**
	 * @param string $content
	 *
	 * @return QuarkCollection|Category[] $categories
	 */
	public function ContentCategories ($content = '') {
		preg_match_all('#\/category\/([0-9]+)\"#Uis', $content, $results);

		/**
		 * @var QuarkCollection|Category[] $categories
		 */
		$categories = new QuarkCollection(new Category());

		foreach ($results[1] as $item)
			$categories[] = QuarkModel::FindOneById(new Category(), $item);

		return $categories;
	}

	/**
	 * @param string $content
	 *
	 * @return array
	 */
	public function ContentCategoriesIDs ($content = '') {
		preg_match_all('#\/category\/([0-9]+)\"#Uis', $content, $results);

		return $results[1];
	}

	/**
	 * @param string $content
	 *
	 * @return QuarkCollection|Article[] $articles
	 */
	public function ContentArticles ($content = '') {
		preg_match_all('#\/article\/([0-9]+)\"#Uis', $content, $results);

		/**
		 * @var QuarkCollection|Article[] $articles
		 */
		$articles = new QuarkCollection(new Article());

		foreach ($results[1] as $item)
			$articles[] = QuarkModel::FindOneById(new Article(), $item);

		return $articles;
	}

	/**
	 * @param string $content
	 *
	 * @return array
	 */
	public function ContentArticlesIDs ($content = '') {
		preg_match_all('#\/article\/([0-9]+)\"#Uis', $content, $results);

		return $results[1];
	}
}
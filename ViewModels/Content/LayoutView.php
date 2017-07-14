<?php

namespace ViewModels\Content;

use Models\Categories_has_Categories;
use Models\Category;
use Models\News;
use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewModelWithResources;
use Quark\IQuarkViewResource;
use Quark\QuarkCollection;
use Quark\QuarkDate;
use Quark\QuarkGenericViewResource;
use Quark\QuarkModel;

class LayoutView implements IQuarkViewModel, IQuarkViewModelWithComponents, IQuarkViewModelWithResources, IQuarkViewModelWithCustomizableLayout {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Content/Layout';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../static/Content/CSS/Layout.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../static/Content/JS/Layout.js';
	}

	/**
	 * @return IQuarkViewResource[]
	 */
	public function ViewResources () {
		return array(
			QuarkGenericViewResource::CSS(__DIR__ . '/../../static/Content/CSS/Front.css'),
			QuarkGenericViewResource::JS(__DIR__ . '/../../static/Content/JS/Front.js')
		);
	}

	/**
	 * @return array|QuarkCollection
	 */
	public function getTopCategories () {
		/**
		 * @var QuarkModel|Category $parent_category
		 * @var QuarkCollection|Categories_has_Categories[] $category_relations
		 */
		$parent_category = QuarkModel::FindOne(new Category(), array(
			'title' => 'category-top-list'
		));
		return QuarkModel::Find(new Categories_has_Categories(), array(
			'parent_id' => $parent_category->id
		));
	}

	public function getBottomCategories () {
		/**
		 * @var QuarkModel|Category $parent_category
		 * @var QuarkCollection|Categories_has_Categories[] $category_relations_parent
		 */
		$parent_category = QuarkModel::FindOne(new Category(), array(
			'title' => 'category-bottom-list'
		));
		$category_relations_parent = QuarkModel::Find(new Categories_has_Categories(), array(
			'parent_id' => $parent_category->id
		));
		$out = array();
		foreach ($category_relations_parent as $item) {
			$out[] = QuarkModel::Find(new Categories_has_Categories(), array(
				'parent_id' => $item->child_id1->id
			));
		}

		return $out;
	}

	/**
	 * @return QuarkCollection|News[]
	 */
	public function getCurrentNews () {
		return QuarkModel::Find(new News(),
			array(
				'publish_date' =>array(
					'$lte' => QuarkDate::GMTNow()->Format('Y-m-d')
				)
			),
			array(
				QuarkModel::OPTION_LIMIT => 3
			)
		);
	}
}
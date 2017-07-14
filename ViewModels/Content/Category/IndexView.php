<?php

namespace ViewModels\Content\Category;
use Models\Category;
use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewResource;
use Quark\QuarkModel;
use ViewModels\Content\ViewBehavior;

/**
 * Class IndexView
 *
 * @package ViewModels\Content\Category
 */
class IndexView implements IQuarkViewModel ,IQuarkViewModelWithCustomizableLayout,IQuarkViewModelWithComponents {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Content/Category/Index';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../static/Content/Category/CSS/Index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../static/Content/Category/JS/Index.js';
	}

	/**
	 * @param $id
	 *
	 * @return array
	 */
	public function getRelatedCategories($id){
		/**
		 * @var QuarkModel|Category $category
		 */
		$category = QuarkModel::FindOneById(new Category(),$id);
		return $category->ChildCategories()->Extract();
	}
	/**
	 * @param $id
	 *
	 * @return array
	 */
	public function getRelatedArticles($id){
		/**
		 * @var QuarkModel|Category $category
		 */
		$category = QuarkModel::FindOneById(new Category(),$id);
		return $category->Articles()->Extract();
	}
}
<?php

namespace ViewModels\Content\Article;
use Models\Article;
use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewResource;
use Quark\QuarkModel;
use ViewModels\Content\ViewBehavior;

class IndexView implements IQuarkViewModel ,IQuarkViewModelWithCustomizableLayout,IQuarkViewModelWithComponents {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Content/Article/Index';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../static/Content/Article/CSS/Index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../static/Content/Article/JS/Index.js';
	}

	/**
	 * @param $id
	 *
	 * @return array
	 */
	public function getRelatedCategories($id){
		/**
		 * @var QuarkModel|Article $article
		 */
		$article = QuarkModel::FindOneById(new Article(),$id);
		return $article->Categories()->Extract();
	}
}
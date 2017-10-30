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
			QuarkGenericViewResource::JS(__DIR__ . '/../../static/Content/JS/Front.js'),
			QuarkGenericViewResource::CSS(__DIR__ . $this->getBackground())
		);
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

	/**
	 * @return mixed
	 */
	public function getBackground(){
		$background_container = array();
		$background_container[0] = '/../../static/Content/CSS/BlueBackground.css';
		$background_container[1] = '/../../static/Content/CSS/YellowBackground.css';
		$background_container[2] = '/../../static/Content/CSS/WhiteBackground.css';
		$background_container[3] = '/../../static/Content/CSS/PinkBackground.css';

		return $background_container[rand(0,3)];
	}
}
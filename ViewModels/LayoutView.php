<?php
namespace ViewModels;

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
use Quark\ViewResources\jQuery\jQueryCore;
use Quark\ViewResources\SimpleMDE\SimpleMDE;
use ViewResources\Quill;

/**
 * Class LayoutView
 *
 * @package ViewModels
 */
class LayoutView implements IQuarkViewModel, IQuarkViewModelWithComponents, IQuarkViewModelWithResources, IQuarkViewModelWithCustomizableLayout {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Layout';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../static/Layout/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../static/Layout/index.js';
	}

	/**
	 * @return IQuarkViewResource[]
	 */
	public function ViewResources () {
		return array(
			QuarkGenericViewResource::CSS(__DIR__ . '/../static/resources/CSS/Front.css'),
			QuarkGenericViewResource::JS(__DIR__ . '/../static/resources/JS/Front.js'),
			QuarkGenericViewResource::CSS(__DIR__ . $this->getBackground())
		);
	}

	/**
	 * @return QuarkCollection|News[]
	 */
	public function getCurrentNews () {
		return QuarkModel::Find(new News(),
			array(
//				'publish_date' =>array(
//					'$lte' => QuarkDate::GMTNow()->Format('Y-m-d')
//				)
			),
			array(
				QuarkModel::OPTION_SORT => array('publish_date' => QuarkModel::SORT_DESC),
				QuarkModel::OPTION_LIMIT => 3
			)
		);
	}

	/**
	 * @return mixed
	 */
	public function getBackground () {
		$background_container = array();
		$background_container[0] = '/../static/resources/CSS/BlueBackground.css';
		$background_container[1] = '/../static/resources/CSS/YellowBackground.css';
		$background_container[2] = '/../static/resources/CSS/WhiteBackground.css';
		$background_container[3] = '/../static/resources/CSS/PinkBackground.css';

		return $background_container[rand(0,3)];
	}

	/**
	 * @param string $title
	 *
	 * @return string
	 */
	public function Title ($title = '') {
		return $title;
	}

	/**
	 * @param int $position
	 *
	 * @return string
	 */
	public function GetColor($position) {
		$colors = array('bg-yellow', 'bg-red', 'bg-blue');

		return $colors[$position % sizeof($colors)];
	}
}
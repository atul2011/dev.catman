<?php
namespace ViewModels\Admin\Category\Group;

use Models\CategoryGroupItem;
use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewModelWithVariableProxy;
use Quark\IQuarkViewResource;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Admin\ViewBehavior;

/**
 * Class IndexView
 *
 * @package ViewModels\Admin\Category\Group
 */
class IndexView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents, IQuarkViewModelWithCustomizableLayout, IQuarkViewModelWithVariableProxy {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function PresenceTitle () {
		return 'Category Group Edit';
	}

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/Category/Group/Index';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../../static/Admin/Category/Group/Index/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../../static/Admin/Category/Group/Index/index.js';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewLayoutStylesheet () {
		return __DIR__ . '/../../../../static/Admin/Behaviors/Form/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewLayoutController () {
		return __DIR__ . '/../../../../static/Admin/Behaviors/Form/index.js';
	}

	/**
	 * @param $vars
	 *
	 * @return mixed
	 */
	public function ViewVariableProxy ($vars) {
		return array(
			'category_group_item_category' => CategoryGroupItem::TYPE_CATEGORY,
			'category_group_item_article' => CategoryGroupItem::TYPE_ARTICLE,
		);
	}
}
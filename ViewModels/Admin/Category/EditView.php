<?php
namespace ViewModels\Admin\Category;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewModelWithResources;
use Quark\IQuarkViewResource;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Admin\ViewBehavior;
use ViewResources\Summernote\Summernote;

/**
 * Class IndexView
 *
 * @package ViewModels\Admin\Category
 */
class EditView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithResources, IQuarkViewModelWithComponents, IQuarkViewModelWithCustomizableLayout {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function PresenceTitle () {
		return 'Category Update';
	}

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/Category/Edit';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../static/Admin/Category/Index/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../static/Admin/Category/Index/index.js';
	}

	/**
	 * @return IQuarkViewResource[]
	 */
	public function ViewResources() {
		return array(
			new Summernote()
		);
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewLayoutStylesheet () {
		return __DIR__ . '/../../../static/Admin/Behaviors/Form/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewLayoutController () {
		return __DIR__ . '/../../../static/Admin/Behaviors/Form/index.js';
	}
}
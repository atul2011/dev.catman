<?php
namespace ViewModels\Admin\News;

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
 * @package ViewModels\Admin\News
 */
class EditView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents, IQuarkViewModelWithResources, IQuarkViewModelWithCustomizableLayout{
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function PresenceTitle () {
		return 'News Edit';
	}

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/News/Edit';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__.'/../../../static/Admin/News/Index/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__.'/../../../static/Admin/News/Index/index.js';
	}

	/**
	 * @return IQuarkViewResource[]
	 */
	public function ViewResources () {
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
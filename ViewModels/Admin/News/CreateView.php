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
 * Class CreateView
 *
 * @package ViewModels\Admin\News
 */
class CreateView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents, IQuarkViewModelWithResources, IQuarkViewModelWithCustomizableLayout {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function PresenceTitle () {
		return 'News Create';
	}

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/News/Create';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__.'/../../../static/Admin/News/Create/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__.'/../../../static/Admin/News/Create/index.js';
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
		return __DIR__ . '/../../../static/Admin/Create/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewLayoutController () {
		return __DIR__ . '/../../../static/Admin/Create/index.js';
	}
}
<?php
namespace ViewModels\Admin\Content\Article;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewModelWithResources;
use Quark\IQuarkViewResource;
use Quark\ViewResources\MediumEditor\MediumEditor;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Admin\Content\Behaviors\ICreateView;
use ViewModels\Admin\ViewBehavior;

/**
 * Class EditView
 *
 * @package ViewModels\Admin\Content\Article
 */
class EditView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents,IQuarkViewModelWithResources,IQuarkViewModelWithCustomizableLayout,ICreateView {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function PresenceTitle () {
		return 'Article Edit';
	}

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/Content/Article/Edit';
	}
	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../../static/Admin/Content/Article/CSS/Edit.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../../static/Admin/Content/Article/JS/Edit.js';
	}

	/**
	 * @return IQuarkViewResource[]
	 */
	public function ViewResources() {
		return array(
			new MediumEditor()
		);
	}
}
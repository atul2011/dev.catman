<?php
/**
 * Created by PhpStorm.
 * User: boagh
 * Date: 19.07.2017
 * Time: 10:41
 */

namespace ViewModels\Admin\Content\Category;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewModelWithResources;
use Quark\IQuarkViewResource;
use Quark\ViewResources\MediumEditor\MediumEditor;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Admin\Content\Behaviors\ICreateView;
use ViewModels\Admin\ViewBehavior;

class EditView implements IQuarkViewModel ,IQuarkPresenceControlViewModel ,IQuarkViewModelWithResources ,IQuarkViewModelWithComponents,IQuarkViewModelWithCustomizableLayout,ICreateView {
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
		return 'Admin/Content/Category/Edit';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../../static/Admin/Content/Category/CSS/Edit.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../../static/Admin/Content/Category/JS/Edit.js';
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
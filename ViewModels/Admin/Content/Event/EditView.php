<?php

namespace ViewModels\Admin\Content\Event;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewResource;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Admin\Content\Behaviors\ICreateView;
use ViewModels\Admin\ViewBehavior;

class EditView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents, IQuarkViewModelWithCustomizableLayout,ICreateView {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function PresenceTitle () {
		return 'Event Edit';
	}

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/Content/Event/Edit';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../../static/Admin/Content/Event/CSS/Edit.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../../static/Admin/Content/Event/JS/Edit.js';
	}
}
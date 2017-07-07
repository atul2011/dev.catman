<?php

namespace ViewModels\Admin\Content\Event;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewModelWithResources;
use Quark\IQuarkViewResource;
use Quark\ViewResources\jQuery\jQueryCore;
use Quark\ViewResources\MediumEditor\MediumEditor;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\Admin\Content\Behaviors\ICreateView;
use ViewModels\Admin\ViewBehavior;

class CreateView implements IQuarkViewModel, IQuarkPresenceControlViewModel, IQuarkViewModelWithComponents, IQuarkViewModelWithResources, IQuarkViewModelWithCustomizableLayout,ICreateView {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function PresenceTitle () {
		return 'Event Management';
	}

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/Content/Event/Create';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../../static/Admin/Content/Event/CSS/Create.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../../static/Admin/Content/Event/JS/Create.js';
	}

	/**
	 * @return IQuarkViewResource[]
	 */
	public function ViewResources () {
		return array(
			new jQueryCore(),
			new MediumEditor()
		);
	}
}
<?php

namespace ViewModels\Content;
use Middleware\Bootstrap;
use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithResources;
use Quark\IQuarkViewResource;
use Quark\QuarkDTO;
use Quark\ViewResources\jQuery\jQueryCore;
use Quark\ViewResources\MediumEditor\MediumEditor;
use Quark\ViewResources\Quark\QuarkPresenceControl\IQuarkPresenceControlViewModel;
use ViewModels\ViewBehavior;

class CategoryEditView implements IQuarkViewModel ,IQuarkPresenceControlViewModel ,IQuarkViewModelWithResources ,IQuarkViewModelWithComponents {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function PresenceTitle () {
		return 'Edit Category';
	}

	/**
	 * @return string
	 */
	public function View () {
		return 'Content/CategoryEdit';
	}
	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../static/EditContent/style.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../static/EditContent/script.js';
	}

	/**
	 * @return IQuarkViewResource[]
	 */
	public function ViewResources() {
		return array(
			new jQueryCore(),
			new MediumEditor()
		);

	}
}
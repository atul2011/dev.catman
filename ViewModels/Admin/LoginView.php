<?php
namespace ViewModels\Admin;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithCustomizableLayout;
use Quark\IQuarkViewModelWithResources;
use Quark\IQuarkViewResource;
use Quark\ViewResources\Google\GoogleFont;
use Quark\ViewResources\jQuery\jQueryCore;
use Quark\ViewResources\Quark\QuarkPresence\QuarkPresence;
use ViewModels\ViewBehavior;

class LoginView implements IQuarkViewModel,IQuarkViewModelWithComponents,IQuarkViewModelWithResources {

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/Login';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../static/Admin/Login/style.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../static/Admin/Login/script.js';
	}

	/**
	 * @return IQuarkViewResource[]
	 */
	public function ViewResources () {
		return array(
			new jQueryCore(),
			new GoogleFont(GoogleFont::FAMILY_MONTSERRAT, GoogleFont::SizeRange()),
			new QuarkPresence()
		);
	}
}
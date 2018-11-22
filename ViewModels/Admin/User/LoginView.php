<?php
namespace ViewModels\Admin\User;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithResources;
use Quark\IQuarkViewResource;
use Quark\ViewResources\Google\GoogleFont;
use Quark\ViewResources\jQuery\jQueryCore;
use Quark\ViewResources\Quark\QuarkPresence\QuarkPresence;

/**
 * Class LoginView
 *
 * @package ViewModels\Admin\User
 */
class LoginView implements IQuarkViewModel,IQuarkViewModelWithComponents,IQuarkViewModelWithResources {

	/**
	 * @return string
	 */
	public function View () {
		return 'Admin/User/Login';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return __DIR__ . '/../../../static/Admin/User/Login/index.css';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return __DIR__ . '/../../../static/Admin/User/Login/index.js';
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
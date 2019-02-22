<?php
namespace ViewModels;

use Quark\IQuarkViewResource;
use Quark\QuarkViewBehavior;
use Quark\ViewResources\FontAwesome\FontAwesome;
use Quark\ViewResources\jQuery\jQueryCore;

/**
 * Class ViewBehavior
 *
 * @package ViewModels
 */
trait ViewBehavior {
	use QuarkViewBehavior;

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewLayoutStylesheet () {
		// TODO: Implement ViewLayoutStylesheet() method.
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewLayoutController () {
		// TODO: Implement ViewLayoutController() method.
	}

	/**
	 * @return IQuarkViewResource[]
	 */
	public function ViewLayoutResources () {
		return array(
			new jQueryCore(),
		    new FontAwesome()
		);
	}
}
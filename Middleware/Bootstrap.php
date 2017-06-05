<?php

namespace Middleware;
use Quark\IQuarkViewResource;
use Quark\IQuarkViewResourceWithDependencies;

/**
 * Class Bootstrap
 *
 * @package Middlewares
 */
class Bootstrap  implements IQuarkViewResource, IQuarkViewResourceWithDependencies {
	/**
	 * @return IQuarkViewResource[]
	 */
	public function Dependencies () {
		return array(
			new BootstrapJS(),
			new BootstrapCSSStyle()
		);
	}
}
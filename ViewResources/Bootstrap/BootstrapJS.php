<?php
namespace ViewResources\Summernote;

use Quark\IQuarkSpecifiedViewResource;
use Quark\IQuarkViewResourceType;
use Quark\QuarkCSSViewResourceType;

class BootstrapJS implements IQuarkSpecifiedViewResource {
	/**
	 * @return IQuarkViewResourceType
	 */
	public function Type () {
		return new QuarkCSSViewResourceType();
	}

	/**
	 * @return string
	 */
	public function Location () {
		return 'http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js';
	}
}
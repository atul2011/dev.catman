<?php
namespace ViewResources\Summernote;

use Quark\IQuarkSpecifiedViewResource;
use Quark\IQuarkViewResourceType;
use Quark\QuarkJSViewResourceType;

/**
 * Class SummernoteJS
 *
 * @package ViewResources\Summernote
 */
class SummernoteJS implements IQuarkSpecifiedViewResource {
	/**
	 * @return IQuarkViewResourceType
	 */
	public function Type () {
		return new QuarkJSViewResourceType();
	}

	/**
	 * @return string
	 */
	public function Location () {
		return 'http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js';
	}
}
<?php
namespace ViewResources\Summernote;

use Quark\IQuarkSpecifiedViewResource;
use Quark\IQuarkViewResourceType;
use Quark\QuarkCSSViewResourceType;

/**
 * Class SummernoteCSS
 *
 * @package ViewResources\Summernote
 */
class SummernoteCSS implements IQuarkSpecifiedViewResource {
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
		return 'http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css';
	}
}
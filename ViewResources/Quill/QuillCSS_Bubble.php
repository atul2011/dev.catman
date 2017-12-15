<?php
namespace ViewResources\Quill;

use Quark\IQuarkSpecifiedViewResource;
use Quark\IQuarkViewResourceType;
use Quark\QuarkCSSViewResourceType;

/**
 * Class QuillCSS_Bubble
 *
 * @package ViewResources\Quill
 */
class QuillCSS_Bubble implements IQuarkSpecifiedViewResource {
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
		return '//cdn.quilljs.com/1.3.4/quill.bubble.css';
	}
}
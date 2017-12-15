<?php
namespace ViewResources\Quill;

use Quark\IQuarkSpecifiedViewResource;
use Quark\IQuarkViewResourceType;
use Quark\QuarkCSSViewResourceType;

/**
 * Class QuillCoreCSS
 *
 * @package ViewResources\Quill
 */
class QuillCoreCSS implements IQuarkSpecifiedViewResource {
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
		return '//cdn.quilljs.com/1.3.4/quill.core.css';
	}
}
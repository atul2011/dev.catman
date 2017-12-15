<?php
namespace ViewResources\Quill;

use Quark\IQuarkSpecifiedViewResource;
use Quark\IQuarkViewResourceType;
use Quark\QuarkJSViewResourceType;

/**
 * Class QuillCoreJS
 *
 * @package ViewResources\Quill
 */
class QuillCoreJS implements IQuarkSpecifiedViewResource {
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
		return '//cdn.quilljs.com/1.3.4/quill.core.js';
	}
}
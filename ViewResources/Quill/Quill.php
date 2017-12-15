<?php
namespace ViewResources\Quill;

use Quark\IQuarkViewResource;
use Quark\IQuarkViewResourceWithBackwardDependencies;

/**
 * Class Quill
 *
 * @package ViewResources
 */
class Quill implements IQuarkViewResourceWithBackwardDependencies {
	/**
	 * @return IQuarkViewResource[]
	 */
	public function BackwardDependencies () {
		return array(
			new QuillCoreJS(),
			new QuillCoreCSS(),
			new QuillJS(),
			new QuillJSmin(),
			new QuillCSS_Snow(),
			new QuillCSS_Bubble()
		);
	}
}
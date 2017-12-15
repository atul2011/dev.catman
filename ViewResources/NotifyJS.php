<?php
namespace ViewResources;

use Quark\IQuarkViewResource;
use Quark\IQuarkViewResourceWithDependencies;
use Quark\QuarkGenericViewResource;

/**
 * Class NotifyJS
 *
 * @package ViewResources
 */
class NotifyJS implements IQuarkViewResource, IQuarkViewResourceWithDependencies {
	/**
	 * @return IQuarkViewResource[]
	 */
	public function Dependencies () {
		return array(
			QuarkGenericViewResource::JS(__DIR__ . '/../static/resources/notifyjs/notify.min.js')
		);
	}
}
<?php
namespace Services\Admin\Behaviors;

use Quark\IQuarkIOProcessor;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;

/**
 * Class CustomProcessorBehavior
 *
 * @package Services\Admin\Behaviors
 */
trait CustomProcessorBehavior {

	/**
	 * @param QuarkDTO $request
	 *
	 * @return IQuarkIOProcessor
	 */
	public function Processor (QuarkDTO $request) {
		return new QuarkJSONIOProcessor();
	}
}
<?php
namespace Services\Admin\Behaviors;
use Quark\IQuarkIOProcessor;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;

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
<?php
namespace Services\Api;

use Quark\IQuarkGetService;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkServiceWithAccessControl;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkSession;

/**
 * Class IndexService
 *
 * @package Services\Api
 */
class IndexService implements IQuarkGetService, IQuarkServiceWithCustomProcessor, IQuarkServiceWithAccessControl {
	use ApiBehavior;

	/**
	 * @return string
	 */
	public function AllowOrigin () {
		return '*';
	}

	/**
	 * @param QuarkDTO $request
	 *
	 * @return IQuarkIOProcessor
	 */
	public function Processor (QuarkDTO $request) {
		return new QuarkJSONIOProcessor();
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		if (!$this->AuthorizeDevice($request))
			return array('status' => 403);

		return array('status' => 200);
	}
}
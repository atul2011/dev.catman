<?php
namespace Services\Admin;

use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\QuarkDTO;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;

class ParserService implements IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		// TODO: Implement Get() method.
	}
}
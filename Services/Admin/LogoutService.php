<?php

namespace Services\Admin;

use Quark\IQuarkAuthorizableService;
use Quark\IQuarkGetService;
<<<<<<< HEAD
use Quark\IQuarkIOProcessor;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkSession;

class LogoutService implements IQuarkPostService,IQuarkGetService, IQuarkServiceWithCustomProcessor,IQuarkAuthorizableService {
=======
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkSession;
use Services\Behaviors\CustomProcessorBehavior;

class LogoutService implements IQuarkPostService,IQuarkGetService, IQuarkServiceWithCustomProcessor,IQuarkAuthorizableService {
	use CustomProcessorBehavior;
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
	/**
	 * @param QuarkDTO $request
	 *
	 * @return string
	 */
	public function AuthorizationProvider (QuarkDTO $request) {
		return MP_SESSION;
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		$session->Logout();
		return QuarkDTO::ForRedirect('/admin/login');
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		$session->Logout();
		return QuarkDTO::ForRedirect('/admin/login');
	}
<<<<<<< HEAD

	/**
	 * @param QuarkDTO $request
	 *
	 * @return IQuarkIOProcessor
	 */
	public function Processor (QuarkDTO $request) {
		return new QuarkJSONIOProcessor();
	}
=======
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
}
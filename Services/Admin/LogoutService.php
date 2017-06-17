<?php

namespace Services\Admin;

use Quark\IQuarkAuthorizableService;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkSession;
use Services\Behaviors\CustomProcessorBehavior;

class LogoutService implements IQuarkPostService,IQuarkGetService, IQuarkServiceWithCustomProcessor,IQuarkAuthorizableService {
	use CustomProcessorBehavior;
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
}
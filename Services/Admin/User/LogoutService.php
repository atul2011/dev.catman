<?php

namespace Services\Admin\User;

use Quark\IQuarkAuthorizableService;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\QuarkDTO;
use Quark\QuarkSession;

class LogoutService implements IQuarkPostService,IQuarkGetService, IQuarkAuthorizableService {
	/**
	 * @param QuarkDTO $request
	 *
	 * @return string
	 */
	public function AuthorizationProvider (QuarkDTO $request) {
		return CM_SESSION;
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		$session->Logout();
		return QuarkDTO::ForRedirect('/admin/user/login');
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		$session->Logout();
		return QuarkDTO::ForRedirect('/admin/user/login');
	}
}
<?php

namespace Services\Admin\User;
use Quark\IQuarkAuthorizableService;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\QuarkDTO;
use Quark\QuarkSession;
use Quark\QuarkView;
use ViewModels\Admin\User\LoginView;

class LoginService implements IQuarkGetService ,IQuarkPostService ,IQuarkAuthorizableService {
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
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return new QuarkView(new LoginView());
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		if(!$session->Login($request,10))
			return new QuarkView(new LoginView());
		return QuarkDTO::ForRedirect('/admin/user/');
	}
}
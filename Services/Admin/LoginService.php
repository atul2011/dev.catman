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
use Quark\QuarkView;
use ViewModels\Admin\LoginView;

class LoginService implements IQuarkGetService ,IQuarkPostService ,IQuarkServiceWithCustomProcessor ,IQuarkAuthorizableService {
=======
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkSession;
use Quark\QuarkView;
use Services\Behaviors\CustomProcessorBehavior;
use ViewModels\Admin\LoginView;

class LoginService implements IQuarkGetService ,IQuarkPostService ,IQuarkServiceWithCustomProcessor ,IQuarkAuthorizableService {
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
		return QuarkDTO::ForRedirect('/admin/');
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
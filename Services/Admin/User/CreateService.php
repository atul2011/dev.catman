<?php

namespace Services\Admin\User;
use Models\User;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use ViewModels\Admin\User\CreateView;

class CreateService implements IQuarkGetService ,IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication {
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
	 * @return bool|mixed
	 */
	public function AuthorizationCriteria (QuarkDTO $request, QuarkSession $session) {
		return 		$session->User()->rights === 'A';
	}

	/**
	 * @param QuarkDTO $request
	 * @param $criteria
	 *
	 * @return mixed
	 */
	public function AuthorizationFailed (QuarkDTO $request, $criteria) {
		return QuarkDTO::ForRedirect('/admin/');
	}
	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new CreateView(),new QuarkPresenceControl());
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		$user = QuarkModel::FindOne(new User(), array(
			'login' => $request->Data()->login
		));
		if ($user !== null)
			return QuarkDTO::ForRedirect('/admin/user/list?create=false');
		$user = new QuarkModel(new User(), array(
			'id'=>$request->Data()->id,
			'login'=>$request->Data()->login,
			'name'=>$request->Data()->name,
			'pass'=>$request->Data()->password,
			'rights'=>$request->Data()->rights,
			'email'=>$request->Data()->email
		));
		if (!$user->Create())
			return QuarkDTO::ForRedirect('/admin/user/list?create=false');

		return QuarkDTO::ForRedirect('/admin/user/list?create=true');
	}
}
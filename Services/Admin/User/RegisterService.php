<?php
namespace Services\Admin\User;

use Models\User;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;

/**
 * Class RegisterService
 *
 * @package Services\Admin\User
 */
class RegisterService implements IQuarkPostService,  IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|User $user
		 */
		$user = QuarkModel::FindOne(new User(), array('login' => $request->Data()->login));

		if ($user != null)
			return array('status' => 409);

		$user = new QuarkModel(new User(), $request->Data());

		if (!$user->Create())
			return array('status' => 500);

		return array('status' => 200);
	}
}
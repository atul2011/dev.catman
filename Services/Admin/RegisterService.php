<?php

namespace Services\Admin;

use Models\User;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Behaviors\AuthorizationBehavior;
use Services\Behaviors\CustomProcessorBehavior;

class RegisterService implements IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;

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
		$user = QuarkModel::FindOne(new User(), array(
			'login' => $request->Data()->login
		));
		if ($user != null)
			return array(
				'status' => 409
			);
		$user = new QuarkModel(new User(), $request->Data());
		if (!$user->Create())
			return QuarkDTO::ForStatus(QuarkDTO::STATUS_500_SERVER_ERROR);
		return QuarkDTO::ForStatus(QuarkDTO::STATUS_200_OK);
	}
}
<?php

namespace Services\Admin\User;

use Models\User;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\CustomProcessorBehavior;
use ViewModels\Admin\User\ListView;

class ListService implements IQuarkGetService, IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
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
		return QuarkDTO::ForRedirect('/admin/user/?error=InvalidRights');
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new ListView(), new QuarkPresenceControl(),
			array(
				'users' => QuarkModel::Find(new User()),
				'number' => QuarkModel::Count(new User())
			)
		);
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkCollection|User $user
		 */
		$limit = 50;
		$skip = 0;
		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;
		if (isset($request->skip) && ($request->skip !== null))
			$skip = $request->skip;
		$user = QuarkModel::Find(new User(), array(), array(
			QuarkModel::OPTION_LIMIT => $limit,
			QuarkModel::OPTION_SKIP => $skip
		));
		$model = 'user';
		if (isset($request->Data()->model) && $request->Data()->model !== null) $model = $request->Data()->model;
		//if is another model, go out
		if ($model !== 'user') {
			return array(
				'status' => 200,
				'response' => null
			);
		}

		return array(
			'status' => 200,
			'response' => $user->Extract(array(
				'id',
				'name',
				'type',
				'keywords'
			))
		);
	}
}
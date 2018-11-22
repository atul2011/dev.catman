<?php
namespace Services\Admin\User;

use Models\News;
use Models\User;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\Status\BadRequestView;
use ViewModels\Admin\Status\CustomErrorView;
use ViewModels\Admin\Status\InternalServerErrorView;
use ViewModels\Admin\Status\NotFoundView;

/**
 * Class DeleteService
 *
 * @package Services\Admin\User
 */
class DeleteService implements IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return bool|mixed
	 */
	public function AuthorizationCriteria (QuarkDTO $request, QuarkSession $session) {
		return 	$session->User()->rights === 'A';
	}

	/**
	 * @param QuarkDTO $request
	 * @param $criteria
	 *
	 * @return mixed
	 */
	public function AuthorizationFailed (QuarkDTO $request, $criteria) {
		return QuarkDTO::ForRedirect('/admin/user/login');
	}
	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		/**
		* @var QuarkModel|User $user
		*/
		$user = QuarkModel::FindOneById(new User(), $request->URI()->Route(3));

		if ($user == null)
			return QuarkView::InLayout(new NotFoundView(), new QuarkPresenceControl());

		if ($user->rights == 'A')
			return QuarkView::InLayout(new BadRequestView(), new QuarkPresenceControl());

		if (!QuarkModel::Delete(new News(), array('lastediteby_userid' => $user->id)))
			return QuarkView::InLayout(new CustomErrorView(), new QuarkPresenceControl(), array(
				'error_status' => 'Status 500: Internal Server Error',
				'error_message' => 'Cannot delete user\'s news'
			));

		if(!$user->Remove())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect('/admin/user/list');
	}
}
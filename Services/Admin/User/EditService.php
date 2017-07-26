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
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\User\CreateView;

class EditService implements IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication,IQuarkGetService {
	use AuthorizationBehavior;
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
		return QuarkView::InLayout(new CreateView(),new QuarkPresenceControl(),array(
			'user'=> QuarkModel::FindOneById(new User(), $request->URI()->Route(3))
		));
	}

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
		$id=$request->URI()->Route(3);
		$event = QuarkModel::FindOneById(new User(),$id);
		if($event === null)
			return QuarkDTO::ForRedirect('/admin/user/list?status=404');

		$event->PopulateWith($request->Data());
		if(!$event->Save())
			return QuarkDTO::ForRedirect('/admin/user/list?update=false');

		return QuarkDTO::ForRedirect('/admin/user/list/'.$id.'?edited=true');
	}
}
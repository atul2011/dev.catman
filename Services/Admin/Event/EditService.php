<?php

namespace Services\Admin\Event;

use Models\Event;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\Content\Event\EditView;

class EditService implements IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication,IQuarkGetService {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new EditView(),New QuarkPresenceControl(),array(
			'event'=> QuarkModel::FindOneById(new Event(), $request->URI()->Route(3))
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
		 * @var QuarkModel|Event $event
		 */
		$id=$request->URI()->Route(3);
		$event = QuarkModel::FindOneById(new Event(),$id);
		if($event === null)
			return QuarkDTO::ForStatus(QuarkDTO::STATUS_404_NOT_FOUND);

		$event->PopulateWith($request->Data());
		if(!$event->Save())
			return QuarkDTO::ForRedirect('/admin/event/list/'.$id.'?edited=false');

		return QuarkDTO::ForRedirect('/admin/event/list/'.$id.'?edited=true');
	}
}
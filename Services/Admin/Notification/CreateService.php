<?php
namespace Services\Admin\Notification;

use Models\Notification;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\Notification\CreateView;
use ViewModels\Admin\Status\InternalServerErrorView;

/**
 * Class CreateService
 *
 * @package Services\Notification
 */
class CreateService implements IQuarkGetService, IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new CreateView(), new QuarkPresenceControl(), array('notification' => new QuarkModel(new Notification())));
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Notification $notification
		 */
		$notification = new QuarkModel(new Notification(), array(
			'content' => $request->content,
			'type' => $request->type,
			'target' => $request->target
		));

		if (!$notification->Create())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect('/admin/notification/list');
	}
}
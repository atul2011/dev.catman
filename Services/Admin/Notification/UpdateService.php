<?php
namespace Services\Admin\Notification;

use Models\Notification;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\Status\InternalServerErrorView;
use ViewModels\Admin\Status\NotFoundView;

/**
 * Class EditService
 *
 * @package Services\Admin\Notification
 */
class UpdateService implements IQuarkPostService,  IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

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
		$notification = QuarkModel::FindOneById(new Notification(), $request->URI()->Route(3));

		if ($notification === null)
			return QuarkView::InLayout(new NotFoundView(), new QuarkPresenceControl());

		$notification->PopulateWith(array(
			'content' => $request->content,
			'type' => $request->type,
			'target' => $request->target
		));

		if (!$notification->Save())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect('/admin/notification/list');
	}
}
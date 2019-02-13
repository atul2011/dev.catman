<?php
namespace Services\Admin\Notification;

use Models\Notification;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\Notification\IndexView;
use ViewModels\Admin\Status\BadRequestView;

/**
 * Class IndexService
 *
 * @package Services\Notification
 */
class IndexService implements IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Notification $notification
		 */
		$notification = QuarkModel::FindOneById(new Notification(), $request->URI()->Route(2));

		if ($notification == null)
			return QuarkView::InLayout(new BadRequestView(), new QuarkPresenceControl());

		return QuarkView::InLayout(new IndexView(), new QuarkPresenceControl(), array('notification' => $notification));
	}
}
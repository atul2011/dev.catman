<?php
namespace Services\Admin\Event;

use Models\Event;
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
 * Class DeleteService
 *
 * @package Services\Admin\Event
 */
class DeleteService implements IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

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
		$event = QuarkModel::FindOneById(new Event(), $request->URI()->Route(3));

		if ($event == null)
			return QuarkView::InLayout(new NotFoundView(), new QuarkPresenceControl());

		if(!$event->Remove())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect('/admin/event/list');
	}
}
<?php
namespace Services\Admin\Event;

use Models\Event;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;

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
		$id = $request->URI()->Route(3);
		$event = QuarkModel::FindOneById(new Event(), $id);
		if (!$event->Remove())
			return QuarkDTO::ForRedirect('/admin/event/list?deleted=false');
		return QuarkDTO::ForRedirect('/admin/event/list?deleted=true');
	}
}
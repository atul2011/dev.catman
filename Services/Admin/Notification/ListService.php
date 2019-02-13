<?php
namespace Services\Admin\Notification;

use Models\Notification;
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
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;
use ViewModels\Admin\Notification\ListView;

/**
 * Class ListService
 *
 * @package Services\Notification
 */
class ListService implements IQuarkGetService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		$current_page = isset($request->page) ? $request->page : 1;
		$page_volume = 50;
		$search = isset($request->search) ? $request->search : '';

		/**
		 * @var QuarkCollection|Notification[] $notifications
		 */
		$notifications = QuarkModel::Find(new Notification());

		return QuarkView::InLayout(new ListView(), new QuarkPresenceControl(), array(
			'notifications' => $notifications->Select(array(), array(
				QuarkModel::OPTION_SORT => array('creatd' => QuarkModel::SORT_DESC),
				QuarkModel::OPTION_LIMIT => $page_volume,
				QuarkModel::OPTION_SKIP => ($current_page - 1) * $page_volume
			)),
			'pages' => (int)($notifications->Count() / $page_volume) + 1,
			'page' => (int)$current_page,
			'search' => $search
		));
	}
}
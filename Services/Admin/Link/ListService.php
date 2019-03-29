<?php
namespace Services\Admin\Link;

use Models\Link;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\Link\ListView;

/**
 * Class ListService
 *
 * @package Services\Admin\Link
 */
class ListService implements IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		$criteria = array();

		if (strlen($request->URI()->Route(3)) > 0 || strlen($request->URI()->Route(4)) > 0) {
			$criteria = array(
				'target_type' => $request->URI()->Route(3),
				'target_value' => $request->URI()->Route(4),
			);
		}

		return QuarkView::InLayout(new ListView(), new QuarkPresenceControl(), array(
			'links' => QuarkModel::Find(new Link(), $criteria, array(
				QuarkModel::OPTION_SORT => array('priority' => QuarkModel::SORT_ASC)
			)),
			'target_type' => $request->URI()->Route(3),
			'target_value' => $request->URI()->Route(4),
		));
	}
}
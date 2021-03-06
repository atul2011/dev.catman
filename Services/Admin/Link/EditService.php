<?php
namespace Services\Admin\Link;

use Models\Link;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\Link\IndexView;
use ViewModels\Admin\Status\InternalServerErrorView;
use ViewModels\Admin\Status\NotFoundView;

/**
 * Class EditService
 *
 * @package Services\Admin\Event
 */
class EditService implements IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication, IQuarkGetService {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new IndexView(), new QuarkPresenceControl(), array('link' => QuarkModel::FindOneById(new Link(), $request->URI()->Route(3))));
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Link $link
		 */
		$link = QuarkModel::FindOneById(new Link(), $request->URI()->Route(3));
		$redirect = '/admin/link/list';

		if ($link === null)
			return QuarkView::InLayout(new NotFoundView(), new QuarkPresenceControl());

		$link->PopulateWith($request->Data());
		$link->master = !isset($request->master) ? false : true;

		if (strlen($link->target_type) > 0 && strlen($link->target_value) > 0) {
			$redirect = $redirect . '/' . $link->target_type . '/' . $link->target_value;
		}

		if (!$link->Save())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect($redirect);
	}
}
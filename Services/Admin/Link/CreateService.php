<?php
namespace Services\Admin\Link;

use Models\Link;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\Quark;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\Link\CreateView;
use ViewModels\Admin\Status\ConflictView;
use ViewModels\Admin\Status\InternalServerErrorView;

/**
 * Class CreateService
 *
 * @package Services\Admin\Link
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
		$target_type = strlen($request->URI()->Route(3)) > 0 ? $request->URI()->Route(3) : '';
		$target_value = strlen($request->URI()->Route(4)) > 0 ? $request->URI()->Route(4) : '';

		return QuarkView::InLayout(new CreateView(), new QuarkPresenceControl(), array(
			'target_type' => $target_type,
		    'target_value' => $target_value
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
		 * @var QuarkModel|Link $link
		 */
		$redirect = '/admin/link/list';
		$link = new QuarkModel(new Link(), $request->Data());

		if (isset($request->target_type) && isset($request->target_value)) {
			$link->type = Link::TYPE_RELATED;
			$redirect = $redirect . '/' . $request->target_type . '/' . $request->target_value;
		}

		$link->master = !isset($request->master) ? false : true;

		if (!$link->Create())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect($redirect);
	}
}
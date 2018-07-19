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
		return QuarkView::InLayout(new CreateView(), new QuarkPresenceControl());
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
		$link = QuarkModel::FindOne(new Link(), array('title' => $request->title));

		if ($link != null)
			return QuarkView::InLayout(new ConflictView(), new QuarkPresenceControl());

		$link = new QuarkModel(new Link(), $request->Data());

		if (!$link->Create())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect('/admin/link/list');
	}
}
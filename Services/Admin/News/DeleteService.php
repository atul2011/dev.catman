<?php
namespace Services\Admin\News;

use Models\News;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
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
 * @package Services\Admin\News
 */
class DeleteService implements IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|News $news
		 */
		$news = QuarkModel::FindOneById(new News(), $request->URI()->Route(3));

		if ($news == null)
			return QuarkView::InLayout(new NotFoundView(), new QuarkPresenceControl());

		if(!$news->Remove())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect('/admin/news/list');
	}
}
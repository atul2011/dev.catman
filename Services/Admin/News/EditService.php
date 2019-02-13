<?php
namespace Services\Admin\News;

use Models\News;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\QuarkDate;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\News\EditView;
use ViewModels\Admin\Status\InternalServerErrorView;
use ViewModels\Admin\Status\NotFoundView;

/**
 * Class EditService
 *
 * @package Services\Admin\News
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
		return QuarkView::InLayout(new EditView(), new QuarkPresenceControl(), array('news'=> QuarkModel::FindOneById(new News(), $request->URI()->Route(3))));
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|News $news
		 */
		$news = QuarkModel::FindOneById(new News(), $request->URI()->Route(3));

		if ($news === null)
			return QuarkView::InLayout(new NotFoundView(),new QuarkPresenceControl());

		$news->PopulateWith($request->Data());
		$news->lastedited_date = QuarkDate::GMTNow('Y-m-d');
		$news->lastediteby_userid = $session->User()->id;

		if (!$news->Save())
			return QuarkView::InLayout(new InternalServerErrorView(),new QuarkPresenceControl());

		return QuarkDTO::ForRedirect('/admin/news/list');
	}
}
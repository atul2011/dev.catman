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
use ViewModels\Admin\News\CreateView;
use ViewModels\Admin\Status\InternalServerErrorView;

/**
 * Class CreateService
 *
 * @package Services\Admin\News
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
		 * @var QuarkModel|News $news
		 */
		$news = new QuarkModel(new News(), $request->Data());

		$news->lastediteby_userid = $session->User()->id;
		$news->lastedited_date = QuarkDate::GMTNow();

		if(!$news->Create())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect('/admin/news/list');
	}
}
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
use ViewModels\Admin\Content\News\EditView;

class EditService implements IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication,IQuarkGetService {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new EditView(),New QuarkPresenceControl(),array(
			'news'=> QuarkModel::FindOneById(new News(), $request->URI()->Route(3))
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
		 * @var QuarkModel|News $news
		 */
		$id = $request->URI()->Route(3);
		$news = QuarkModel::FindOneById(new News(),$id);
		if($news === null)
			return QuarkDTO::ForStatus(QuarkDTO::STATUS_404_NOT_FOUND);

		$news->PopulateWith($request->Data());
		$news->lastedited_date = QuarkDate::GMTNow('Y-m-d');
		$news->lastediteby_userid = $session->User()->id;

		if(!$news->Save())
			return QuarkDTO::ForRedirect('/admin/news/list/?edited=false');

		return QuarkDTO::ForRedirect('/admin/news/list/?edited=true');
	}
}
<?php

namespace Services\Admin\News;
use Models\News;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\Quark;
use Quark\QuarkDate;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;
use ViewModels\Admin\Content\News\CreateView;

class CreateService implements IQuarkGetService,IQuarkPostService ,IQuarkServiceWithCustomProcessor ,IQuarkAuthorizableServiceWithAuthentication {
	use CustomProcessorBehavior;
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new CreateView(),new QuarkPresenceControl());
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
		$news = new QuarkModel(new News(),$request->Data());
		$news->lastediteby_userid = $session->User()->id;
		$news->lastedited_date = QuarkDate::GMTNow();

		if(!$news->Create())
			return QuarkDTO::ForRedirect('/admin/news/list?created=false');

		return QuarkDTO::ForRedirect('/admin/news/list?created=true');
	}
}
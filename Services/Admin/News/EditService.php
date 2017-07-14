<?php
/**
 * Created by PhpStorm.
 * User: boagh
 * Date: 11.07.2017
 * Time: 16:55
 */

namespace Services\Admin\News;
use Models\News;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;
use ViewModels\Admin\Content\News\CreateView;

class EditService implements IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication,IQuarkGetService {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new CreateView(),New QuarkPresenceControl(),array(
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
		if(!$news->Save())
			return QuarkDTO::ForRedirect('/admin/news/list/'.$id.'?edited=false');

		return QuarkDTO::ForRedirect('/admin/news/list/'.$id.'?edited=true');
	}
}
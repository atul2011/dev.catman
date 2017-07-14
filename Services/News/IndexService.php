<?php

namespace Services\News;
use Models\News;
use Quark\IQuarkGetService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use ViewModels\Content\LayoutView;
use ViewModels\Content\News\IndexView;
use ViewModels\Content\Status\NotFoundView;

/**
 * Class IndexService
 *
 * @package Services\News
 */
class IndexService implements IQuarkGetService {
	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		$id = $request->URI()->Route(1);
		if(!is_numeric($id))
			return QuarkView::InLayout(new NotFoundView(),new LayoutView(),array(
				'model' => 'News'
			));

		/**
		 * @var QuarkModel|News $news
		 */
		$news = QuarkModel::FindOneById(new News(),$id);
		if($news == null)
			return QuarkView::InLayout(new NotFoundView(),new LayoutView(),array(
				'model' => 'News'
			));

		return QuarkView::InLayout(new IndexView(),new LayoutView(),array(
			'news' => $news->Extract()
		));
	}
}
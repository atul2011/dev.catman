<?php
namespace Services\News;

use Models\News;
use Quark\IQuarkGetService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use ViewModels\LayoutView;
use ViewModels\News\IndexView;
use ViewModels\Status\NotFoundView;

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
		if (!is_numeric($request->URI()->Route(1)))
			return QuarkView::InLayout(new NotFoundView(), new LayoutView(), array('model' => 'News'));

		/**
		 * @var QuarkModel|News $news
		 */
		$news = QuarkModel::FindOneById(new News(), $request->URI()->Route(1));

		if ($news == null)
			return QuarkView::InLayout(new NotFoundView(), new LayoutView(), array('model' => 'News'));

		return QuarkView::InLayout(new IndexView(),new LayoutView(),array(
			'news' => $news->Extract(),
			'title' => $news->title
		));
	}
}
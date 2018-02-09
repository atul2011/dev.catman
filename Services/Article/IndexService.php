<?php
namespace Services\Article;

use Models\Article;
use Quark\IQuarkGetService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use ViewModels\Article\IndexView;
use ViewModels\LayoutView;
use ViewModels\Status\NotFoundView;

/**
 * Class IndexService
 *
 * @package Services\Article
 */
class IndexService implements IQuarkGetService {
	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Article $article
		 */
		$article = QuarkModel::FindOneById(new Article(), $request->URI()->Route(1));

		if ($article == null)
			return QuarkView::InLayout(new NotFoundView(), new LayoutView(), array(
				'model'=> 'Article',
				'title' => 'Status: 404'
			));

		if ($article->available_on_site == false)
			return QuarkView::InLayout(new NotFoundView(), new LayoutView(), array(
				'model'=> 'Article',
				'title' => 'Status: 404'
			));

		return QuarkView::InLayout(new IndexView(),new LayoutView(),array(
			'article' => $article,
			'title' => $article->title
		));
	}
}
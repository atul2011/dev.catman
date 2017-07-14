<?php

namespace Services\Article;
use Models\Article;
use Quark\IQuarkGetService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use ViewModels\Content\Article\IndexView;
use ViewModels\Content\LayoutView;
use ViewModels\Content\Status\NotFoundView;

/**
 * Class IndexService
 *
 * @package Services\Article
 */
class IndexService implements IQuarkGetService{
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
				'model'=> 'Article'
			));

		/**
		 * @var QuarkModel|Article $article
		 */
		$article = QuarkModel::FindOneById(new Article(),$id);
		if($article == null)
			return QuarkView::InLayout(new NotFoundView(),new LayoutView(),array('model'=> 'Article'));

		return QuarkView::InLayout(new IndexView(),new LayoutView(),array(
			'article' => $article
		));
	}
}
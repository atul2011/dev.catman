<?php

namespace Services;
use Models\Article;
use Models\Banner;
use Quark\IQuarkGetService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use ViewModels\Content\IndexView;
use ViewModels\Content\LayoutView;

/**
 * Class IndexService
 *
 * @package Services
 */
class IndexService implements IQuarkGetService {

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new IndexView(),new LayoutView(),array(
			'article' => QuarkModel::FindOneById(new Article(),1),
			'banners' => QuarkModel::Find(new Banner())
		));
	}
}
<?php
namespace Services\Category;

use Models\Category;
use Quark\IQuarkGetService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use ViewModels\Content\Category\IndexView;
use ViewModels\Content\LayoutView;
use ViewModels\Content\Status\NotFoundView;

/**
 * Class IndexService
 *
 * @package Services\Category
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
			return QuarkView::InLayout(new NotFoundView(), new LayoutView(),array('model'=> 'Category'));

		/**
		 * @var QuarkModel|Category $category
		 */
		$category = QuarkModel::FindOneById(new Category(),$id);

		if($category == null)
			return QuarkView::InLayout(new NotFoundView(),new LayoutView(),array('model'=> 'Category'));

		return QuarkView::InLayout(new IndexView(), new LayoutView(), array('category' => $category));
	}
}
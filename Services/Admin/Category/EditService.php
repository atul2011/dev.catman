<?php
namespace Services\Admin\Category;

use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\Quark;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\Category\EditView;
use ViewModels\Admin\Status\InternalServerErrorView;
use ViewModels\Admin\Status\NotFoundView;

/**
 * Class EditService
 *
 * @package Services\Admin\Category
 */
class EditService implements IQuarkPostService, IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Category $category
		 */
		if (!is_numeric($request->URI()->Route(3)))
			return QuarkView::InLayout(new NotFoundView(), new QuarkPresenceControl());

		$category = QuarkModel::FindOneById(new Category(), $request->URI()->Route(3));

		if ($category == null)
			return QuarkView::InLayout(new NotFoundView(), new QuarkPresenceControl());

		return QuarkView::InLayout(new EditView(), new QuarkPresenceControl(), array('category' => $category));
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *s
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Category $category
		 */
		$category = QuarkModel::FindOneById(new Category(), $request->URI()->Route(3));

		if ($category === null)
			return array('status' => 404);
		$category->PopulateWith($request->Data());

		$category->available_on_site = !isset($request->available_on_site) ? false : true;
		$category->available_on_api = !isset($request->available_on_api) ? false : true;

		if (!$category->Save())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect('/admin/category/list/');
	}
}
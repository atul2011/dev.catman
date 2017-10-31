<?php
namespace Services\Admin\Category;

use Models\Articles_has_Categories;
use Models\Categories_has_Categories;
use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;
use ViewModels\Admin\Status\AccessForbiddenView;
use ViewModels\Admin\Status\CustomErrorView;
use ViewModels\Admin\Status\InternalServerErrorView;
use ViewModels\Admin\Status\NotFoundView;

/**
 * Class DeleteService
 *
 * @package Services\Admin\Category
 */
class DeleteService implements IQuarkPostService, IQuarkServiceWithCustomProcessor,IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Category $category
		 */
		$category = QuarkModel::FindOneById(new Category(), $request->URI()->Route(3));

		if ($category->role == Category::ROLE_SYSTEM)
			return QuarkView::InLayout(new AccessForbiddenView(), new QuarkPresenceControl());

		if ($category == null)
			return QuarkView::InLayout(new NotFoundView(), new QuarkPresenceControl());

		if (!QuarkModel::Delete(new Categories_has_Categories(), array('child_id1' => $category->id)))
			return QuarkView::InLayout(new CustomErrorView(), new QuarkPresenceControl(), array(
				'error_status' => 'Status 500: Internal Server Error',
				'error_message' => 'Cannot delete relationships of category as child'
			));

		if (!QuarkModel::Delete(new Categories_has_Categories(), array('parent_id' => $category->id)))
			return QuarkView::InLayout(new CustomErrorView(), new QuarkPresenceControl(), array(
				'error_status' => 'Status 500: Internal Server Error',
				'error_message' => 'Cannot delete relationships of category as parent'
			));

		if (!QuarkModel::Delete(new Articles_has_Categories(), array('category_id' => $category->id)))
			return QuarkView::InLayout(new CustomErrorView(), new QuarkPresenceControl(), array(
				'error_status' => 'Status 500: Internal Server Error',
				'error_message' => 'Cannot delete relationships of category with articles'
			));

		if (!$category->Remove())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect('/admin/category/list');
	}
}
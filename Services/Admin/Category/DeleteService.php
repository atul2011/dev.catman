<?php
namespace Services\Admin\Category;

use Models\Articles_has_Categories;
use Models\Categories_has_Categories;
use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class DeleteService
 *
 * @package Services\Admin\Category
 */
class DeleteService implements IQuarkGetService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;

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
		$category = QuarkModel::FindOneById(new Category(), $request->URI()->Route(3));

		if ($category->role == Category::ROLE_SYSTEM)
			return array('status' => 403);

		if ($category == null)
			return array('status' => 404);

		if (!QuarkModel::Delete(new Categories_has_Categories(), array('child_id1' => $category->id)))
			return array(
				'status' => 500,
				'message' => 'Cannot delete category\'s parents relations'
			);

		if (!QuarkModel::Delete(new Categories_has_Categories(), array('parent_id' => $category->id)))
			return array(
				'status' => 500,
				'message' => 'Cannot delete category\'s childs relations'
			);

		if (!QuarkModel::Delete(new Articles_has_Categories(), array('category_id' => $category->id)))
			return array(
				'status' => 500,
				'message' => 'Cannot delete category\'s articles relation'
			);

		if (!$category->Remove())
			return array('status' => 500);

		return array('status' => 200);
	}
}
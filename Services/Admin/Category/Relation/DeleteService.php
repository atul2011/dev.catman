<?php
namespace Services\Admin\Category\Relation;

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
 * @package Services\Admin\Category\Relation
 */
class DeleteService implements IQuarkGetService, IQuarkServiceWithCustomProcessor,IQuarkAuthorizableServiceWithAuthentication {
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
		 * @var QuarkModel|Category $parent_category
		 * @var QuarkModel|Category $child_category
		 */
		$parent_category = QuarkModel::FindOneById(new Category(), $request->URI()->Route(4));

		if ($parent_category == null)
			return array('status' => 404);

		$child_category = QuarkModel::FindOneById(new Category(), $request->URI()->Route(5));

		if ($child_category == null)
			return array('status' => 400);

		return array('status' => QuarkModel::Delete(new Categories_has_Categories(), array(
			'parent_id' => $parent_category->id,
			'child_id1' => $child_category->id
		)) ? 200 : 500);
	}
}

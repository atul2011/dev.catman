<?php
namespace Services\Admin\Category\Relation;

use Models\Categories_has_Categories;
use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\Quark;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class PriorityService
 *
 * @package Services\Admin\Category\Relation
 */
class PriorityService implements IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
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
		 * @var QuarkModel|Category $parent
		 * @var QuarkModel|Category $child
		 */
		$parent = QuarkModel::FindOneById(new Category(), $request->parent_id);

		if ($parent == null)
			return array(
				'status' => 400,
				'message' => 'Cannot find parent category!'
			);

		$child = QuarkModel::FindOneById(new Category(), $request->child_id);

		if ($child == null)
			return array(
				'status' => 400,
				'message' => 'Cannot find child category!'
			);

		/**
		 * @var QuarkModel|Categories_has_Categories $relation
		 */

		$relation = QuarkModel::FindOne(new Categories_has_Categories(), array(
			'parent_id' => $parent->id,
			'child_id1' => $child->id
		));

		if ($relation == null)
			return array(
				'status' => 400,
				'message' => 'Cannot find relation!'
			);

		$relation->priority = (int)$request->priority;

		return array('status' => $relation->Save() ? 200 : 500);
	}
}
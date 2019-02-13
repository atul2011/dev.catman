<?php
namespace Services\Admin\Category\Relation;

use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class CategoriesService
 *
 * @package Services\Admin\Category\Relation
 */
class CategoriesService implements IQuarkGetService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
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
		$category = QuarkModel::FindOneById(new Category(), $request->URI()->Route(4));

		if ($category == null)
			return array('status' => 404);

		$limit = isset($request->limit) ? $request->limit : 50;

		/**
		 * @var QuarkCollection|Category[] $child_categories
		 */
		$child_categories = $category->ChildCategories($limit);

		$processed_child_categories = new QuarkCollection(new Category());

		foreach ($child_categories as $item) {
			$item->SetRuntimePriority($category);
			$processed_child_categories[] = $item;
		}

		return array(
			'status' => 200,
			'category' => $category->Extract(),
			'children' => $processed_child_categories->Extract(array(
					'id',
					'title',
					'priority',
					'role',
					'runtime_priority',
					'runtime_category'
				)
			),
			'parent' => $category->ParentCategories($limit)->Extract(array(
                     'id',
                     'title',
                     'priority',
                     'role'
                 )
			)
		);
	}
}
<?php
namespace Services\Admin\Category\Relation;

use Models\Articles_has_Categories;
use Models\Categories_has_Categories;
use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class ClearService
 *
 * @package Services\Admin\Category\Relation
 */
class ClearService implements IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication, IQuarkServiceWithCustomProcessor {
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
			return array('status' => 400);

		/**
		 * @var QuarkCollection|Categories_has_Categories[] $links
		 */
		$links = QuarkModel::Find(new Categories_has_Categories(), array('parent_id' => (string)$category->id));

		foreach ($links as $link) {
			if (!$link->Remove())
				return array(
					'status' => 500,
					'errors' => array('Cannot delete link category-category with id:' .  $link->id)
				);
		}

		unset($links);

		/**
		 * @var QuarkCollection|Articles_has_Categories[] $links
		 */
		$links =  QuarkModel::Find(new Articles_has_Categories(), array('category_id' => (string)$category->id));

		foreach ($links as $link) {
			if (!$link->Remove())
				return array(
					'status' => 500,
					'errors' => array('Cannot delete link article-category with id:' .  $link->id)
				);
		}

		unset($links);

		return array('status' => 200);
	}
}
<?php
namespace Services\Admin\Category;

use Models\Category;
use Models\Categories_has_Categories;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class LinkService
 *
 * @package Services\Category
 */
class LinkService implements IQuarkServiceWithCustomProcessor, IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication {
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
		 * @var QuarkModel|Categories_has_Categories $link
		 */
		$parent = QuarkModel::FindOneById(new Category(), $request->Data()->parent);

		if ($parent == null)
			return array(
				'status' => 400,
				'Parent category\' id is invalid'
			);

		/**
		 * @var QuarkModel|Category $child
		 */
		$child = QuarkModel::FindOneById(new Category(), $request->Data()->child);

		if ($child == null)
			return array(
				'status' => 400,
				'Child category\' id is invalid'
			);

		$link = QuarkModel::FindOne(new Categories_has_Categories(), array(
			'parent_id' => $parent->id,
			'child_id1' => $child->id
		));

		if ($link != null)
			return array('status' => 409);

		$link = new QuarkModel(new Categories_has_Categories(), array(
			'parent_id' => $parent,
			'child_id1' => $child,
			'priority' => null
		));

		if (!$link->Create())
			return array('status' => 400);

		return array(
			'status' => 200,
			'category' => $parent->id
		);
	}
}
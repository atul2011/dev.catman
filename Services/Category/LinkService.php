<?php

namespace Services\Category;

use Models\Category;
use Models\Categories_has_Categories;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\Quark;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Behaviors\AuthorizationBehavior;

/**
 * Class LinkService
 *
 * @package Services\Category
 */
class LinkService implements IQuarkServiceWithCustomProcessor, IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	//add a relation in table categories_has_categories
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Category $parent
		 * @var QuarkModel|Category $child
		 * @var QuarkModel|Categories_has_Categories $link
		 */
		$parent = QuarkModel::FindOneById(new Category(), $request->Data()->parent);
		if ($parent == null) return array(
			'status' => 404
		);
		$child = QuarkModel::FindOneById(new Category(), $request->Data()->child);
		if ($child == null) return array(
			'status' => 404
		);
		$link = QuarkModel::FindOne(new Categories_has_Categories(), array(
			'parent_id' => $parent->id,
			'child_id1' => $child->id
		));
		if ($link != null) return array(
			'status' => 409
		);
		$link = new QuarkModel(new Categories_has_Categories(), array(
			'parent_id' => $parent,
			'child_id1' => $child,
			'priority' => null
		));
		if (!$link->Create()) return array(
			'status' => 400
		);

		return array(
			'status' => 200,
			'category' => $parent->id
		);
	}

	/**
	 * @param QuarkDTO $request
	 *
	 * @return IQuarkIOProcessor
	 */
	public function Processor (QuarkDTO $request) {
		return new QuarkJSONIOProcessor();
	}
}
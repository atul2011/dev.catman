<?php

namespace Services\Category;

use Models\Articles_has_Categories;
use Models\Categories_has_Categories;
use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Exception;
use Services\Behaviors\AuthorizationBehavior;

class DeleteService implements IQuarkPostService, IQuarkServiceWithCustomProcessor,IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Category $category
		 * @var QuarkCollection|Categories_has_Categories[] $category_parent_links
		 * @var QuarkCollection|Categories_has_Categories[] $category_child_links
		 * @var QuarkCollection|Articles_has_Categories[] $article_links
		 */
		$id = $request->URI()->Route(2);
		try {
			QuarkModel::Delete(new Categories_has_Categories(), array(
				'parent_id' => $id
			));
			QuarkModel::Delete(new Categories_has_Categories(), array(
				'child_id1' => $id
			));
			QuarkModel::Delete(new Articles_has_Categories(), array(
				'category_id' => $id
			));
			QuarkModel::Delete(new Category(), array(
				'id' => $id
			));
		}
		catch (Exception $e) {
			return $e;
		}
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
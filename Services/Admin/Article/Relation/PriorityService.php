<?php
namespace Services\Admin\Article\Relation;

use Models\Article;
use Models\Articles_has_Categories;
use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class PriorityService
 *
 * @package Services\Admin\Article\Relation
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
		 * @var QuarkModel|Category $category
		 */
		$category = QuarkModel::FindOneById(new Category(), $request->parent_id);

		if ($category == null)
			return array(
				'status' => 400,
				'message' => 'Cannot find category!'
			);

		/**
		 * @var QuarkModel|Article $article
		 */
		$article = QuarkModel::FindOneById(new Article(), $request->child_id);

		if ($article == null)
			return array(
				'status' => 400,
				'message' => 'Cannot find child article!'
			);

		/**
		 * @var QuarkModel|Articles_has_Categories $relation
		 */

		$relation = QuarkModel::FindOne(new Articles_has_Categories(), array(
			'article_id' => $article->id,
			'category_id' => $category->id
		));

		if ($relation == null)
			return array(
				'status' => 400,
				'message' => 'Cannot find relation!'
			);

		$relation->priority = $request->priority;

		return array('status' => $relation->Save() ? 200 : 500);
	}
}
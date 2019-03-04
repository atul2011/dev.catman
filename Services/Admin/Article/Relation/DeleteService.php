<?php
namespace Services\Admin\Article\Relation;

use Models\Article;
use Models\Articles_has_Categories;
use Models\Category;
use Models\CategoryGroupItem;
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
 * Class DeleteService
 *
 * @package Services\Admin\Article\Relation
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
		$category = QuarkModel::FindOneById(new Category(), $request->URI()->Route(4));

		if ($category == null)
			return array('status' => 404);

		/**
		 * @var QuarkModel|Article $article
		 */
		$article = QuarkModel::FindOneById(new Article(), $request->URI()->Route(5));

		if ($article == null)
			return array('status' => 400);

		$ok = QuarkModel::Delete(new Articles_has_Categories(), array('article_id' => $article->id, 'category_id' => $category->id));

		if (!$ok)
			return array('status' => 500);

		/**
		 * @var QuarkCollection|CategoryGroupItem[] $items
		 */
		$items = QuarkModel::Find(new CategoryGroupItem(), array(
			'type' => CategoryGroupItem::TYPE_ARTICLE,
		    'target' => (string)$article->id
		));
		foreach ($items as $item) {
			if (!$item->Remove())
				return array(
					'status' => 500,
				    'errors' => array('Cannot delete group item with article:' . $article->id)
				);
		}

		return array('status' => $ok ? 200 : 500);
	}
}
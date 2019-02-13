<?php
namespace Services\Admin\Category\Group\Item;

use Models\Article;
use Models\Category;
use Models\CategoryGroup;
use Models\CategoryGroupItem;
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
 * Class CreateService
 *
 * @package Services\Admin\Category\Group\Item
 */
class CreateService implements IQuarkPostService,IQuarkAuthorizableServiceWithAuthentication, IQuarkServiceWithCustomProcessor {
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
		 * @var QuarkModel|CategoryGroup $group
		 */
		$group = QuarkModel::FindOneById(new CategoryGroup(), $request->group);

		if ($group == null)
			return array(
				'status' => 404,
			    'errors' => array('Invalid Group')
			);

		/**
		 * @var QuarkModel|CategoryGroupItem $item
		 */
		$item = QuarkModel::FindOne(new CategoryGroupItem(), array(
			'category' => $group->category,
			'type' => htmlspecialchars($request->type),
			'target' => htmlspecialchars($request->target)
		));

		if ($item != null) {
			if ((string)$item->category_group->id == (string)$group->id)
				return array('status' => 409);

			$item->category_group = $group;

			if (!$item->Save())
				return array('status' => 500);

			return array('status' => 200);
		}

		$item = new QuarkModel(new CategoryGroupItem(), array(
			'category_group' => $group,
		    'type' => htmlspecialchars($request->type),
		    'target' => htmlspecialchars($request->target)
		));

		if ($request->type == CategoryGroupItem::TYPE_CATEGORY) {
			/**
			 * @var QuarkModel|Category $category
			 */
			$category = QuarkModel::FindOneById(new Category(), $request->target);

			if ($category == null)
				return array(
					'status' => 400,
					'errors' => array('Invalid Category')
				);
		}
		elseif($request->type == CategoryGroupItem::TYPE_ARTICLE) {
			/**
			 * @var QuarkModel|Article $article
			 */
			$article = QuarkModel::FindOneById(new Article(), $request->target);

			if ($article == null)
				return array(
					'status' => 400,
					'errors' => array('Invalid Article')
				);
		}

		if (!$item->Create())
			return array('status' => 500);

		return array('status' => 200);
	}
}
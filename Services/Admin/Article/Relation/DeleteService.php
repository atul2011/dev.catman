<?php
namespace Services\Admin\Article\Relation;

use Models\Article;
use Models\Articles_has_Categories;
use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;
use ViewModels\Admin\Status\CustomErrorView;

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
			return QuarkView::InLayout(
				new CustomErrorView(), new QuarkPresenceControl(), array('error_status' => 'Status 400: Bad Request', 'error_message' => 'Cannot find category!'));

		/**
		 * @var QuarkModel|Article $article
		 */
		$article = QuarkModel::FindOneById(new Article(), $request->URI()->Route(5));

		if ($article == null)
			return QuarkView::InLayout(
				new CustomErrorView(), new QuarkPresenceControl(), array('error_status' => 'Status 400: Bad Request', 'error_message' => 'Cannot find article!'));

		return array('status' => QuarkModel::Delete(new Articles_has_Categories(), array('article_id' => $article->id, 'category_id' => $category->id)) ? 200 : 500);
	}
}
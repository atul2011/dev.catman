<?php
namespace Services\Admin\Article;

use Models\Article;
use Models\Articles_has_Categories;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class DeleteService
 *
 * @package Services\Articles
 */
class DeleteService implements IQuarkGetService, IQuarkServiceWithCustomProcessor,IQuarkAuthorizableServiceWithAuthentication {
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
		 * @var QuarkModel|Article $article
		 */
		$article = QuarkModel::FindOneById(new Article(), $request->URI()->Route(3));

		if ($article == null)
			return array('status' => 404);

		if (!QuarkModel::Delete(new Articles_has_Categories(), array('article_id' => $article->id)))
			return array(
				'status' => 500,
				'message' => 'Cannot delete article\'s relation'
			);

		if (!$article->Remove())
			return array('status' => 500);

		return array('status' => 200);
	}
}
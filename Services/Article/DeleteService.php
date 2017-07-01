<?php

namespace Services\Article;

use Models\Article;
use Models\Articles_has_Categories;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Exception;
use Services\Behaviors\AuthorizationBehavior;
use Services\Behaviors\CustomProcessorBehavior;

/**
 * Class DeleteService
 *
 * @package Services\Articles
 */
class DeleteService implements IQuarkPostService, IQuarkServiceWithCustomProcessor,IQuarkAuthorizableServiceWithAuthentication {
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
		 * @var QuarkModel|Article $article
		 * @var QuarkCollection|Articles_has_Categories[] $article_links
		 */
		$id = $request->URI()->Route(2);
		try {
			if($request->Data()->type_of_delete === 'all')
			QuarkModel::Delete(new Article(), array(
				'id' => $id
			));
			QuarkModel::Delete(new Articles_has_Categories(), array(
				'article_id' => $id
			));
		}
		catch (Exception $e) {
			return $e;
		}
	}
}
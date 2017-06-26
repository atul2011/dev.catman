<?php

namespace Services\Article;

use Models\Article;
use Models\Articles_has_Categories;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
<<<<<<< HEAD
use Quark\IQuarkIOProcessor;
=======
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
<<<<<<< HEAD
use Quark\QuarkJSONIOProcessor;
=======
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
use Quark\QuarkModel;
use Quark\QuarkSession;
use Exception;
use Services\Behaviors\AuthorizationBehavior;
<<<<<<< HEAD
=======
use Services\Behaviors\CustomProcessorBehavior;
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4

/**
 * Class DeleteService
 *
 * @package Services\Articles
 */
class DeleteService implements IQuarkPostService, IQuarkServiceWithCustomProcessor,IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
<<<<<<< HEAD
=======
	use CustomProcessorBehavior;
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4

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
<<<<<<< HEAD

	/**
	 * @param QuarkDTO $request
	 *
	 * @return IQuarkIOProcessor
	 */
	public function Processor (QuarkDTO $request) {
		return new QuarkJSONIOProcessor();
	}
=======
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
}
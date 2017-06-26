<?php

namespace Services\Article;

use Models\Article;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
<<<<<<< HEAD
use Quark\IQuarkIOProcessor;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Behaviors\AuthorizationBehavior;
=======
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Behaviors\AuthorizationBehavior;
use Services\Behaviors\CustomProcessorBehavior;
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4

/**
 * Class IndexService
 *
 * @package Services\Articles
 */
class IndexService implements IQuarkGetService, IQuarkServiceWithCustomProcessor,IQuarkAuthorizableServiceWithAuthentication {
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
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return array(
			'status' => 200,
			'item' => QuarkModel::FindOneById(new Article(), $request->URI()->Route(1))->Extract(
				array(
					'id',
					'title'
				)
			)
		);
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
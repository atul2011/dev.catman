<?php

namespace Services\Event;

use Models\Event;
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
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Behaviors\AuthorizationBehavior;

class SearchService implements IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
=======
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Behaviors\AuthorizationBehavior;
use Services\Behaviors\CustomProcessorBehavior;

class SearchService implements IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
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
		 * @var QuarkCollection|Event[] $event
		 */
<<<<<<< HEAD
		$event = QuarkModel::Find(new Event());
		$limit = 50;

		$out = $event->Select(
			array('name' => array('$regex' => '#.*' . $request->name . '.*#Uis')),
			array(QuarkModel::OPTION_LIMIT => $limit)
=======
		$limit = 50;
		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;
		$event = QuarkModel::Find(new Event());
		$out = $event->Select(
			array($request->Data()->field => array('$regex' => '#.*' . $request->Data()->value . '.*#Uis')),
			array(
				QuarkModel::OPTION_LIMIT => $limit
			)
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
		);

		return array(
			'status' => 200,
			'response' => $out->Extract(array(
					'id',
					'name',
					'type',
					'keywords'
				)
			));
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
<?php

namespace Services\Event;

use Models\Event;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Behaviors\AuthorizationBehavior;

class SearchService implements IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

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
		$event = QuarkModel::Find(new Event());
		$limit = 50;

		$out = $event->Select(
			array('name' => array('$regex' => '#.*' . $request->name . '.*#Uis')),
			array(QuarkModel::OPTION_LIMIT => $limit)
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

	/**
	 * @param QuarkDTO $request
	 *
	 * @return IQuarkIOProcessor
	 */
	public function Processor (QuarkDTO $request) {
		return new QuarkJSONIOProcessor();
	}
}
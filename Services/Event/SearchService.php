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
		$out = new QuarkCollection(new Event());
		$i = 0;
		$limit = 50;
		if (isset($request->limit)) $limit = $request->limit;
		$i = $limit;
		foreach ($event as $item) {
			if ($i > 0)
				if (preg_match('#.*' . $request->name . '.*#Uis', $item->name) > 0) {
					$out[] = $item;
					--$i;
				}
		}

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
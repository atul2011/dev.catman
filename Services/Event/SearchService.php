<?php

namespace Services\Event;

use Models\Event;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Behaviors\AuthorizationBehavior;
use Services\Behaviors\CustomProcessorBehavior;

class SearchService implements IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
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
		 * @var QuarkCollection|Event[] $event
		 */
		$limit = 50;
		$skip = 0;
		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;
		if (isset($request->skip) && ($request->skip !== null))
			$skip = $request->skip;
		$event = QuarkModel::Find(new Event());
		$out = $event->Select(
			array($request->Data()->field => array('$regex' => '#.*' . $request->Data()->value . '.*#Uis')),
			array(
				QuarkModel::OPTION_LIMIT => $limit,
				QuarkModel::OPTION_SKIP => $skip
			)
		);

		return array(
			'status' => 200,
			'response' => $out->Extract(array(
					'id',
					'name',
					'type',
					'keywords'
				)
			)
//		, 'number' => $out->Count()
		);
	}
}
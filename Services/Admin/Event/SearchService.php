<?php
namespace Services\Admin\Event;

use Models\Event;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class SearchService
 *
 * @package Services\Admin\Event
 */
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
		 * @var QuarkCollection|Event[] $events
		 */
		$limit = 50;

		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;

		if ($request->field == 'id' && is_numeric($request->field)) {
			/**
			 * @var QuarkModel|Event $event
			 */
			$event = QuarkModel::FindOneById(new Event(), $request->value);
			$out = array();

			if ($event != null)
				$out[] = $event->Extract(array(
                     'id',
                     'name',
                     'type',
                     'keywords'
                 ));

			return array(
				'status' => 200,
				'response' => $out
			);
		}

		$events = QuarkModel::Find(new Event(), array(
				$request->Data()->field => array('$regex' => '#.*' . $request->Data()->value . '.*#Uisu')
			), array(QuarkModel::OPTION_LIMIT => $limit)
		);

		return array(
			'status' => 200,
			'response' => $events->Extract(array(
					'id',
					'name',
					'type',
					'keywords'
			))
		);
	}
}
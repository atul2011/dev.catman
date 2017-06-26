<?php

namespace Services\Event;

use Models\Event;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
<<<<<<< HEAD
use Quark\IQuarkIOProcessor;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
=======
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Behaviors\AuthorizationBehavior;
<<<<<<< HEAD
=======
use Services\Behaviors\CustomProcessorBehavior;
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
use ViewModels\Content\Event\ListView;

class ListService implements IQuarkGetService, IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
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
<<<<<<< HEAD
		return QuarkView::InLayout(new ListView(), new QuarkPresenceControl());
=======
		return QuarkView::InLayout(new ListView(), new QuarkPresenceControl(), array(
			'number' => QuarkModel::Count(new Event())
		));
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
<<<<<<< HEAD
		 * @var QuarkModel|Event $event
		 */
		$event = QuarkModel::Find(new Event(), array(), array(
			QuarkModel::OPTION_LIMIT => 50
		));
		$model = 'event';
=======
		 * @var QuarkCollection|Event $event
		 */
		$limit = 50;
		$skip = 0;
		$model = 'event';
		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;
		if (isset($request->skip) && ($request->skip !== null))
			$skip = $request->skip;
		$event = QuarkModel::Find(new Event(), array(), array(
			QuarkModel::OPTION_LIMIT => $limit,
			QuarkModel::OPTION_SKIP => $skip
		));
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
		if (isset($request->Data()->model) && $request->Data()->model !== null) $model = $request->Data()->model;
		//if is another model, go out
		if ($model !== 'event') {
			return array(
				'status' => 200,
				'response' => null
			);
		}

		return array(
			'status' => 200,
			'response' => $event->Extract(array(
					'id',
					'name',
					'startdate'
				)
<<<<<<< HEAD
			));
	}

	/**
	 * @param QuarkDTO $request
	 *
	 * @return IQuarkIOProcessor
	 */
	public function Processor (QuarkDTO $request) {
		return new QuarkJSONIOProcessor();
=======
			)
//		, 'number' =>$event->Count()
		);
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
	}
}
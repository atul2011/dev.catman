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
use ViewModels\Content\Event\CreateView;

class CreateService implements IQuarkGetService, IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
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
		return QuarkView::InLayout(new CreateView(), new QuarkPresenceControl());
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Event $event
		 */
		$event = QuarkModel::FindOne(new Event(), array(
			'name' => $request->Data()->name
		));
		if ($event !== null)
			return QuarkDTO::ForStatus(QuarkDTO::STATUS_500_SERVER_ERROR);
		$event = new QuarkModel(new Event(), $request->Data());
		if (!$event->Create())
			return QuarkDTO::ForStatus(QuarkDTO::STATUS_500_SERVER_ERROR);

		return QuarkDTO::ForRedirect('/event/list?create=true');
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
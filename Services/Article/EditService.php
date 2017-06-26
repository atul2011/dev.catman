<?php

namespace Services\Article;

use Models\Article;
use Models\Author;
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
use ViewModels\Content\Article\CreateView;

class EditService implements IQuarkPostService, IQuarkGetService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
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
		$id = $request->URI()->Route(2);

		return QuarkView::InLayout(new CreateView(), new QuarkPresenceControl(), array(
			'article' => QuarkModel::FindOneById(new Article(), $id)
		));
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Article $article
		 * @var QuarkModel|Author $author
		 * @var QuarkModel|Event $event
		 */
		$id = $request->URI()->Route(2);
		$article = QuarkModel::FindOneById(new Article(), $id);
		if ($article === null)
			return QuarkDTO::ForStatus(QuarkDTO::STATUS_404_NOT_FOUND);
		$article->PopulateWith($request->Data());

		$author = QuarkModel::FindOne(new Author(), array(
			'name' => $request->Data()->author
		));
		$event = QuarkModel::FindOne(new Event(), array(
			'name' => $request->Data()->event
		));

		$article->event_id = $event->id;
		$article->author_id = $author->id;

		if (!$article->Save())
			return QuarkDTO::ForStatus(QuarkDTO::STATUS_500_SERVER_ERROR);
		if (isset($request->source) && $request->source === 'EditContent')
			return QuarkDTO::ForRedirect('/article/list/' . $id . '?edited=true');

		return QuarkDTO::ForRedirect('/admin/categories?edited=article');
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
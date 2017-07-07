<?php

namespace Services\Admin\Article;

use Models\Article;
use Models\Author;
use Models\Event;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;
use ViewModels\Admin\Content\Article\CreateView;

/**
 * Class CreateService
 *
 * @package Services\Article
 */
class CreateService implements IQuarkPostService, IQuarkGetService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
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
		 * @var QuarkModel|Article $article
		 * @var QuarkModel|Author $author
		 * @var QuarkModel|Event $event
		 */
		//ceck if new article is already exist
		$article = QuarkModel::FindOne(new Article(), array(
			'title' => $request->Data()->title
		));
		if ($article !== null)
			return QuarkDTO::ForStatus(QuarkDTO::STATUS_500_SERVER_ERROR);
		//create new article
		$article = new QuarkModel(new Article(), $request->Data());

		$author = QuarkModel::FindOne(new Author(), array(
			'name' => $request->Data()->author
		));
		$event = QuarkModel::FindOne(new Event(), array(
			'name' => $request->Data()->event
		));

		$article->event_id = $event->id;
		$article->author_id = $author->id;

		if (!$article->Create())
			return QuarkDTO::ForRedirect('/admin/article/create?created=false');

		return QuarkDTO::ForRedirect('/admin/article/list?created=true');
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new CreateView(), new QuarkPresenceControl());
	}
}
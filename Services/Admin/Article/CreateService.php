<?php
namespace Services\Admin\Article;

use Models\Article;
use Models\Author;
use Models\Event;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\QuarkDate;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\Article\CreateView;
use ViewModels\Admin\Status\BadRequestView;
use ViewModels\Admin\Status\ConflictView;
use ViewModels\Admin\Status\InternalServerErrorView;

/**
 * Class CreateService
 *
 * @package Services\Article
 */
class CreateService implements IQuarkPostService, IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

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
		$article = QuarkModel::FindOne(new Article(), array('title' => $request->title));

		if ($article != null)//ceck if new article is already exist
			return QuarkView::InLayout(new ConflictView(), new QuarkPresenceControl());

		$article = new QuarkModel(new Article(), $request->Data());

		$article->publish_date = $request->publishdate != '' ? $request->publishdate : QuarkDate::GMTNow('Y-m-d');
		$article->release_date = $request->releasedate != '' ? $request->releasedate : QuarkDate::GMTNow('Y-m-d');
		$article->priority = $request->priority != '' ? $request->priority : 100;

		if ($request->author != '') {
			$author = QuarkModel::FindOne(new Author(), array('name' => $request->author));
			$article->author_id = $author->id;
		} /*else {
			$article->author_id = Author::DefaultAuthor()->id;
		}*/

		if ($request->event != '') {
			$event = QuarkModel::FindOne(new Event(), array('name' => $request->event));
			$article->event_id = $event->id;
		} /*else {
			$article->event_id = Event::DefaultEvent()->id;
		}*/

		//set tags
		$tags = $request->Data()->tag_list != '' ? explode(',',$request->Data()->tag_list) : array();

		$article->setTags($tags);

		if (!$article->Validate())
			return QuarkView::InLayout(new BadRequestView(), new QuarkPresenceControl());

		if (!$article->Create())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect('/admin/article/list');
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
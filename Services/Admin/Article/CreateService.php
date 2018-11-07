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
use ViewModels\Admin\Status\CustomErrorView;
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
//		$article = QuarkModel::FindOne(new Article(), array('title' => $request->title));
//
//		if ($article != null)//ceck if new article is already exist
//			return QuarkView::InLayout(new ConflictView(), new QuarkPresenceControl());

		$article = new QuarkModel(new Article(), $request->Data());

		$article->publish_date = $request->publishdate != '' ? $request->publishdate : QuarkDate::GMTNow('Y-m-d H:i');
		$article->release_date = $request->releasedate != '' ? $request->releasedate : QuarkDate::GMTNow('Y-m-d');
		$article->priority = $request->priority != '' ? $request->priority : 100;

		$author = QuarkModel::FindOneById(new Author(), $request->author_id);

		if ($author == null)
			return QuarkView::InLayout(new CustomErrorView(), new QuarkPresenceControl(), array(
				'error_status' => 'Status 400: Bad Request',
				'error_message' => 'Author is invalid'
			));

		$article->author_id = $author->id;

		$event = QuarkModel::FindOneById(new Event(), $request->event_id);

		if ($event == null)
			return QuarkView::InLayout(new CustomErrorView(), new QuarkPresenceControl(), array(
				'error_status' => 'Status 400: Bad Request',
				'error_message' => 'Event is invalid'
			));

		$article->event_id = $event->id;

		$article->available_on_site = !isset($request->available_on_site) ? false : true;
		$article->available_on_api = !isset($request->available_on_api) ? false : true;

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
		return QuarkView::InLayout(new CreateView(), new QuarkPresenceControl(), array(
			'authors' => QuarkModel::Find(new Author(), array(), array(
				QuarkModel::OPTION_SORT => array('name' => QuarkModel::SORT_ASC)
			)),
			'events' => QuarkModel::Find(new Event(), array(), array(
				QuarkModel::OPTION_SORT => array('name' => QuarkModel::SORT_ASC)
			))
		));
	}
}
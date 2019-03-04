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
use ViewModels\Admin\Article\EditView;
use ViewModels\Admin\Status\BadRequestView;
use ViewModels\Admin\Status\CustomErrorView;
use ViewModels\Admin\Status\InternalServerErrorView;
use ViewModels\Admin\Status\NotFoundView;

/**
 * Class EditService
 *
 * @package Services\Admin\Article
 */
class EditService implements IQuarkPostService, IQuarkGetService,  IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		$id = $request->URI()->Route(3);

		if (!is_numeric($id))
			return QuarkView::InLayout(new BadRequestView(), new QuarkPresenceControl());

		/**
		 * @var QuarkModel|Article $article
		 */
		$article = QuarkModel::FindOneById(new Article(), $id);

		if ($article == null)
			return QuarkView::InLayout(new NotFoundView(), new QuarkPresenceControl());

		return QuarkView::InLayout(new EditView(), new QuarkPresenceControl(), array(
			'article' => QuarkModel::FindOneById(new Article(), $id),
			'authors' => QuarkModel::Find(new Author(), array(), array(
				QuarkModel::OPTION_SORT => array('name' => QuarkModel::SORT_ASC)
			)),
			'events' => QuarkModel::Find(new Event(), array(), array(
				QuarkModel::OPTION_SORT => array('name' => QuarkModel::SORT_ASC)
			))
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
		$id = $request->URI()->Route(3);
		$article = QuarkModel::FindOneById(new Article(), $id);

		if ($article === null)
			return QuarkView::InLayout(new NotFoundView(), new QuarkPresenceControl());

		$article->PopulateWith($request->Data());

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
//
//		$article->publish_date = QuarkDate::FromFormat('Y-m-d', $request->publish_date);
//
//		$article->release_date = QuarkDate::FromFormat('Y-m-d H:i', $request-->release_date);

		$article->available_on_site = !isset($request->available_on_site) ? false : true;
		$article->available_on_api = !isset($request->available_on_api) ? false : true;
		$article->master = !isset($request->master) ? false : true;

		if (!$article->Save())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect('/admin/article/list');
	}
}
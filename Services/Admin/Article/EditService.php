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
use ViewModels\Admin\Content\Article\CreateView;

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
		if(!is_numeric($id))
			return QuarkDTO::ForStatus(QuarkDTO::STATUS_404_NOT_FOUND);
		/**
		 * @var QuarkModel|Article $article
		 */
		$article =  QuarkModel::FindOneById(new Article(),$id);

		if($article == null)
			return QuarkDTO::ForStatus(QuarkDTO::STATUS_404_NOT_FOUND);


		return QuarkView::InLayout(new CreateView(), new QuarkPresenceControl(), array(
			'article' => QuarkModel::FindOneById(new Article(), $id),
			'tags' => $article->getTags()
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

		$article->publish_date = QuarkDate::FromFormat('Y-m-d', $request->Data()->publish_date);
		$article->release_date = QuarkDate::FromFormat('Y-m-d', $request->Data()->release_date);

		//set tags
		$request->Data()->tag_list != '' ? $tags  = explode(',',$request->Data()->tag_list)
			: $tags  = array();

		$article->setTags($tags);

		if (!$article->Save())
			return QuarkDTO::ForStatus(QuarkDTO::STATUS_500_SERVER_ERROR);
		if (isset($request->source) && $request->source === 'EditContent')
			return QuarkDTO::ForRedirect('/admin/article/list/' . $id . '?edited=true');

		return QuarkDTO::ForRedirect('/admin/structures/categories?edited=article');
	}
}
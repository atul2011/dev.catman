<?php

namespace Services\Admin\Article;

use Models\Article;
use Models\Author;
use Models\Event;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\Content\Article\CreateView;

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
		//ceck if new article is already exist

		$article = QuarkModel::FindOne(new Article(), array(
			'title' => $request->title
		));
		if ($article !== null)
			return QuarkDTO::ForRedirect('/admin/article/create?create=false');
		//create new article

		$article = new QuarkModel(new Article(), $request->Data());

		$publish_date = $request->Data()->publishdate;
		$release_date = $request->Data()->releasedate;

		if($publish_date !== '')
			$article->publish_date = $publish_date;

		if($release_date !== '')
			$article->release_date = $release_date;

		if($request->Data()->author !== ''){
			$author = QuarkModel::FindOne(new Author(), array(
				'name' => $request->Data()->author
			));

			$article->author_id = $author->id;
		}

		if($request->Data()->event !== ''){
			$event = QuarkModel::FindOne(new Event(), array(
				'name' => $request->Data()->event
			));

			$article->event_id = $event->id;
		}

		//set tags
		$request->Data()->tag_list != '' ? $tags  = explode(',',$request->Data()->tag_list)
			: $tags  = array();

		$article->setTags($tags);

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
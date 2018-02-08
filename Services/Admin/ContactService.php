<?php
namespace Services\Admin;

use Models\Article;
use Quark\IQuarkAuthorizableService;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\Quark;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\ContactView;
use ViewModels\Admin\Status\InternalServerErrorView;
use ViewModels\Status\NotFoundView;

/**
 * Class ContactService
 *
 * @package Services\Admin
 */
class ContactService implements IQuarkGetService, IQuarkPostService, IQuarkAuthorizableService {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Article $article
		 */
		$article = QuarkModel::FindOne(new Article(), array(
			'type' => Article::TYPE_SYSTEM,
			'keywords' => Article::KEYWORDS_CONTACT_US
		));

		if ($article == null) {
			$article = new QuarkModel(new Article());
			$article->type = Article::TYPE_SYSTEM;
			$article->keywords = Article::KEYWORDS_CONTACT_US;

			if (!$article->Create())
				return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());
		}

		return QuarkView::InLayout(new ContactView(), new QuarkPresenceControl(), array('item' => $article));
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
		 */
		$article = QuarkModel::FindOneById(new Article(), $request->URI()->Route(2));

		if ($article == null)
			return QuarkView::InLayout(new NotFoundView(), new QuarkPresenceControl());

		$article->PopulateWith($request->Data());

		if (!$article->Save())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect('/admin/');
	}
}
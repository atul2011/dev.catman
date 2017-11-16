<?php
namespace Services\Admin\Article;

use Models\Article;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;

/**
 * Class SstService
 *
 * @package Services\Admin\Article
 *//*SstService => SetShortTitleService*/
class SstService implements IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		$page = $request->page != '' ? $request->page : 1;
		$limit = $request->limit != '' ? $request->limit : 500;
		/**
		 * @var QuarkCollection|Article[] $articles
		 */
		$articles = QuarkModel::FindByPage(new Article(), $page, array(), array(QuarkModel::OPTION_LIMIT => $limit));

		foreach ($articles as $article) {
			$article->short_title = $article->title;

			if (!$article->Save())
				Quark::Log('Cannot save article:' . $article->id);
		}

		return QuarkDTO::ForRedirect('/admin/article/list');
	}
}
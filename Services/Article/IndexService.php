<?php
namespace Services\Article;

use Models\Article;
use Models\Breadcrumb;
use Models\Category;
use Models\Event;
use Models\Link;
use Quark\IQuarkAuthorizableService;
use Quark\IQuarkGetService;
use Quark\Quark;
use Quark\QuarkDate;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Services\ServicesBehavior;
use ViewModels\Article\IndexView;
use ViewModels\LayoutView;
use ViewModels\Status\NotFoundView;

/**
 * Class IndexService
 *
 * @package Services\Article
 */
class IndexService implements IQuarkGetService, IQuarkAuthorizableService {
	use ServicesBehavior;

	/**
	 * @param QuarkDTO $request
	 *
	 * @return string
	 */
	public function AuthorizationProvider (QuarkDTO $request) {
		return CM_SESSION;
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		$session_id = $session->ID() != null ? $session->ID()->Value() : sha1($request->Remote()->host . QuarkDate::GMTNow('d-m-Y'));

		/**
		 * @var QuarkModel|Article $article
		 */
		$article = QuarkModel::FindOneById(new Article(), $request->URI()->Route(1));
		//echo "here";exit;
		if ($article == null)
			return QuarkView::InLayout(new NotFoundView(), new LayoutView(), array(
				'model'=> 'Article',
				'title' => 'Status: 404'
			));

		if ($article->available_on_site == false)
			return QuarkView::InLayout(new NotFoundView(), new LayoutView(), array(
				'model'=> 'Article',
				'title' => 'Status: 404'
			));

		$content = str_replace('<p><br></p>', ' ', $article->txtfield);

		if (strlen($content) > 0)
			$article->txtfield = $content;

		if (!$article->Save())
			Quark::Log('Cannot save article ' . $article->id, Quark::LOG_FATAL);

		$this->SetUserBreadcrumb($session_id, null, $article);//Set breadcrumb


		return QuarkView::InLayout(new IndexView(),new LayoutView(),array(
			'article' => $article,
			'links' => QuarkModel::Find(new Link(), array(
				'target_type' => Link::TARGET_TYPE_ARTICLE,
				'target_value' => (int)$article->id
			)),
			'title' => $article->title,
			'user' => $session_id
		));
	}
}

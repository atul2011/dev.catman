<?php
namespace Services\Admin\Article;

use Models\Article;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDate;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;

/**
 * Class ParseService
 *
 * @package Services\Admin\Article
 */
class ParseService implements IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		$page = $request->page != '' ? $request->page : 0;
		$limit = $request->limit != '' ? $request->limit : 25;
		/**
		 * @var QuarkCollection|Article[] $articles
		 */
		$articles = QuarkModel::Find(new Article(), array(), array(
			QuarkModel::OPTION_LIMIT => $limit,
			QuarkModel::OPTION_SKIP => $limit * $page
		));

		foreach ($articles as $article) {
			if (explode('-', $article->release_date)[0] == '')
				$article->release_date = QuarkDate::GMTNow('Y-m-d');

			if (explode('-', $article->publish_date)[0] == '')
				$article->publish_date = QuarkDate::GMTNow('Y-m-d');
//I parser
			$processed = preg_replace('#href=\\\"javascript:goPage\(\\\\\'\/showcat\.php\?id=([0-9]+)\\\\\'\)\\\#Uis', 'href="/category/$1', $article->txtfield);

			if ($processed != '')
				$article->txtfield;
//II parser
			$processed = preg_replace('#href=\\\"\/showcat\.php\?id=([0-9]+)\\\#Uis', 'href="/category/$1', $article->txtfield);

			if ($processed != '')
				$article->txtfield;
//III parser
			$processed = preg_replace('#href=\\\"\\\\\"\/showcat\.php\?id=([0-9]+)\\\\\"#Uis', 'href="/category/$1', $article->txtfield);

			if ($processed != '')
				$article->txtfield;
//IV parser
			$processed = preg_replace('#href=\\\"\/article\.php\?id=([0-9]+)\\\#Uis', 'href="/article/$1', $article->txtfield);

			if ($processed != '')
				$article->txtfield;
//V parser
			$processed = preg_replace('#href=\\\"\\\\\"\/article\.php\?id=([0-9]+)\\\\\"#Uis', 'href="/article/$1', $article->txtfield);

			if ($processed != '')
				$article->txtfield;
//VI parser
			$processed = preg_replace('#href=\\\\\"http:\/\/www\.universalpath\.org\/article\.php\?id=([0-9]+)\\\\\"#Uis', 'href="/article/$1"', $article->txtfield);

			if ($processed != '')
				$article->txtfield = $processed;

			if (!$article->Save())
				Quark::Log('Cannot save article:' . $article->id);
		}

		return QuarkDTO::ForRedirect('/admin/article/list');
	}
}
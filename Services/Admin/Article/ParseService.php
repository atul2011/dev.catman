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
			if (explode('-', $article->release_date)[0] == '' || explode('-', $article->release_date)[0] == null || $article->release_date == null)
				$article->release_date = QuarkDate::GMTNow('Y-m-d');

			if (explode('-', $article->publish_date)[0] == '' || explode('-', $article->publish_date)[0] == null || $article->publish_date == null)
				$article->publish_date = QuarkDate::GMTNow('Y-m-d');

			if ($article->type == '')
				$article->type = Article::TYPE_ARTICLE;
//I parser
			$processed = preg_replace('#href=\\\"javascript:goPage\(\\\\\'\/showcat\.php\?id=([0-9]+)\\\\\'\)\\\#Uis', 'href="/category/$1', $article->txtfield);

			if ($processed != null)
				$article->txtfield = $processed;
//II parser
			$processed = preg_replace('#href=\\\"\/showcat\.php\?id=([0-9]+)\\\#Uis', 'href="/category/$1', $article->txtfield);

			if ($processed != null)
				$article->txtfield = $processed;
//III parser
			$processed = preg_replace('#href=\\\\\"\/showcat\.php\?id=([0-9]+)\\\#Uis', 'href="/category/$1', $article->txtfield);

			if ($processed != null)
				$article->txtfield = $processed;
//IV parser
			$processed = preg_replace('#href=\\\"\/article\.php\?id=([0-9]+)\\\#Uis', 'href="/article/$1', $article->txtfield);

			if ($processed != null)
				$article->txtfield = $processed;
//V parser
			$processed = preg_replace('#href=\\\\\"\/article\.php\?id=([0-9]+)\\\#Uis', 'href="/article/$1', $article->txtfield);

			if ($processed != null)
				$article->txtfield = $processed;
//VI parser
			$processed = preg_replace('#href=\\\\\"http:\/\/www\.universalpath\.org\/article\.php\?id=([0-9]+)\\\\\"#Uis', 'href="/article/$1"', $article->txtfield);

			if ($processed != null)
				$article->txtfield = $processed;
//VII Parser
			$processed = preg_replace('#href=\\\\\"http:\/\/www\.universalpath\.org\/showcat\.php\?id=([0-9]+)\\\\\"#Uis', 'href="/category/$1"', $article->txtfield);

			if ($processed != '')
				$article->txtfield = $processed;
//VIII Parser
			$processed = preg_replace('#\\\\\"#Uis', '"', $article->txtfield);

			if ($processed != '')
				$article->txtfield = $processed;
//IX Parser
			$processed = preg_replace('#\\\\\"#Uis', '"', $article->title);

			if ($processed != '')
				$article->title = $processed;

			if (!$article->Save())
				Quark::Log('Cannot save article:' . $article->id);
		}

		return QuarkDTO::ForRedirect('/admin/article/list');
	}
}
<?php
namespace Services\Admin\Article;

use Models\Article;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;

class ParseService implements IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		$page = $request->page != '' ? $request->page : 1;
		/**
		 * @var QuarkCollection|Article[] $articles
		 */
		$articles = QuarkModel::FindByPage(new Article(), $page , array(), array(QuarkModel::OPTION_LIMIT => 100));

		foreach ($articles as $article) {
			$processed = preg_replace('#href=\\\"javascript:goPage\(\\\\\'\/showcat\.php\?id=([0-9]+)\\\\\'\)\\\#Uis', 'href="/category/$1', $article->txtfield);

			if ($processed != '')
				$article->txtfield;

			$processed = preg_replace('#href=\\\"\/showcat\.php\?id=([0-9]+)\\\#Uis', 'href="/category/$1', $article->txtfield);

			if ($processed != '')
				$article->txtfield;

			$processed = preg_replace('#href=\\\"\/article\.php\?id=([0-9]+)\\\#Uis', 'href="/article/$1', $article->txtfield);

			if ($processed != '')
				$article->txtfield;

			$processed = preg_replace('#href=\\\\\"http:\/\/www\.universalpath\.org\/article\.php\?id=([0-9]+)\\\\\"#Uis', 'href="/article/$1"', $article->txtfield);

			if ($processed != '')
				$article->txtfield = $processed;

			if (!$article->Save())
				Quark::Log('Cannot save article:' . $article->id);
		}

		return QuarkDTO::ForRedirect('/admin/article/list');
	}
}
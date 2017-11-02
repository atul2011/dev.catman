<?php
namespace Services\Admin;

use Models\Article;
use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkConfig;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;

/**
 * Class ParserService
 *
 * @package Services\Admin
 */
class ParserService implements IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkCollection|Category[] $categories
		 */
		$categories = QuarkModel::Find(new Category(), array('id' => 353));

		foreach ($categories as $category) {
			if (!$category->Validate())
				$category->sub = Category::TYPE_CATEGORY;

			$processed = preg_replace('#href=\\\"javascript:goPage\(\\\\\'\/showcat\.php\?id=([0-9]+)\\\\\'\)\\\#Uis', 'href="/category/$1', $category->intro);

			if ($processed != '')
				$category->intro = $processed;

			$processed = preg_replace('#href=\\\"\/showcat\.php\?id=([0-9]+)\\\#Uis', 'href="/category/$1', $category->intro);

			if ($processed != '')
				$category->intro = $processed;

			$processed = preg_replace('#href=\\\"\/article\.php\?id=([0-9]+)\\\#Uis', 'href="/article/$1', $category->intro);

			if ($processed != '')
				$category->intro = $processed;

			$processed = preg_replace('#href=\\\\\"http:\/\/www\.universalpath\.org\/article\.php\?id=([0-9]+)\\\\\"#Uis', 'href="/article/$1"', $category->intro);

			if ($processed != '')
				$category->intro = $processed;

			if (!$category->Save())
				Quark::Log('Cannot save category:' . $category->id);
		}

		$page = $request->page != '' ? $request->page : 1;
		/**
		 * @var QuarkCollection|Article[] $articles
		 */
		$articles = QuarkModel::FindByPage(new Article(), $page , array(), array(QuarkModel::OPTION_LIMIT => 300));

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

		return QuarkDTO::ForRedirect('/admin/');
	}
}
<?php
namespace Services\Admin\Category;

use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;

/**
 * Class ParseService
 *
 * @package Services\Admin\Category
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
		/**
		 * @var QuarkCollection|Category[] $categories
		 */
		$categories = QuarkModel::Find(new Category());

		foreach ($categories as $category) {
			if (!$category->Validate())
				$category->sub = Category::TYPE_CATEGORY;

//I Parser
			$processed = preg_replace('#href=\\\"javascript:goPage\(\\\\\'\/showcat\.php\?id=([0-9]+)\\\\\'\)\\\#Uis', 'href="/category/$1', $category->intro);

			if ($processed != '')
				$category->intro = $processed;
//II Parser
			$processed = preg_replace('#href=\\\"\/showcat\.php\?id=([0-9]+)\\\#Uis', 'href="/category/$1', $category->intro);

			if ($processed != '')
				$category->intro = $processed;
//III parser
			$processed = preg_replace('#href=\\\\\"\/showcat\.php\?id=([0-9]+)\\\#Uis', 'href="/category/$1', $category->intro);

			if ($processed != null)
				$category->intro = $processed;
//IV Parser
			$processed = preg_replace('#href=\\\"\/article\.php\?id=([0-9]+)\\\#Uis', 'href="/article/$1', $category->intro);

			if ($processed != '')
				$category->intro = $processed;
//V parser
			$processed = preg_replace('#href=\\\\\"\/article\.php\?id=([0-9]+)\\\#Uis', 'href="/article/$1', $category->intro);

			if ($processed != null)
				$category->intro = $processed;
//VI Parser
			$processed = preg_replace('#href=\\\\\"http:\/\/www\.universalpath\.org\/article\.php\?id=([0-9]+)\\\\\"#Uis', 'href="/article/$1"', $category->intro);

			if ($processed != '')
				$category->intro = $processed;
//VII Parser
			$processed = preg_replace('#href=\\\\\"http:\/\/www\.universalpath\.org\/showcat\.php\?id=([0-9]+)\\\\\"#Uis', 'href="/category/$1"', $category->intro);

			if ($processed != '')
				$category->intro = $processed;
//VIII Parser
			$processed = preg_replace('#\\\\\"#Uis', '"', $category->intro);

			if ($processed != '')
				$category->intro = $processed;

			if (!$category->Save())
				Quark::Log('Cannot save category:' . $category->id);
		}

		return QuarkDTO::ForRedirect('/admin/category/list');
	}
}
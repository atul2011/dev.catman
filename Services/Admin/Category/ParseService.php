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
//		$categories = QuarkModel::Find(new Category());
		$categories = QuarkModel::Find(new Category(), array('id' => '172'));
		foreach ($categories as $category) {
			if (!$category->Validate())
				$category->sub = Category::TYPE_CATEGORY;

//I Parser
//			$processed = preg_replace('#href=\\\"javascript:goPage\(\\\\\'\/showcat\.php\?id=([0-9]+)\\\\\'\)\\\#Uis', 'href="/category/$1', $category->intro);
//
//			if ($processed != '')
//				$category->intro = $processed;
//II Parser
//			$processed = preg_replace('#href=\\\"\/showcat\.php\?id=([0-9]+)\\\#Uis', 'href="/category/$1', $category->intro);
//
//			if ($processed != '')
//				$category->intro = $processed;
//III parser
//			$processed = preg_replace('#href=\\\\\"\/showcat\.php\?id=([0-9]+)\\\#Uis', 'href="/category/$1', $category->intro);
//
//			if ($processed != null)
//				$category->intro = $processed;
//IV Parser
//			$processed = preg_replace('#href=\\\"\/article\.php\?id=([0-9]+)\\\#Uis', 'href="/article/$1', $category->intro);
//
//			if ($processed != '')
//				$category->intro = $processed;
//V parser
//			$processed = preg_replace('#href=\\\\\"\/article\.php\?id=([0-9]+)\\\#Uis', 'href="/article/$1', $category->intro);
//
//			if ($processed != null)
//				$category->intro = $processed;
//VI Parser
//			$processed = preg_replace('#href=\\\\\"http:\/\/www\.universalpath\.org\/article\.php\?id=([0-9]+)\\\\\"#Uis', 'href="/article/$1"', $category->intro);
//
//			if ($processed != '')
//				$category->intro = $processed;
//VII Parser
//			$processed = preg_replace('#href=\\\\\"http:\/\/www\.universalpath\.org\/showcat\.php\?id=([0-9]+)\\\\\"#Uis', 'href="/category/$1"', $category->intro);
//
//			if ($processed != '')
//				$category->intro = $processed;
//VIII Parser
//			$processed = preg_replace('#\<a href=\"http:\/\/.*\/.*\/.*\/.*\/.*\/.*\.mp3\"\>.*\<\/a\>.#Uis', '', $category->intro);
//
//			if ($processed != '')
//				$category->intro = $processed;
//IX Parser
//			$processed = preg_replace('#<table([\s\S]+)(\/sound\/)([\s\S]+)table>#Uis', '', $category->intro);
//
//			if ($processed != null && strlen($processed) > 0)
//				$category->intro = $processed;
//X Parser
//			$processed = preg_replace('#\\\\\"#Uis', '"', $category->intro);
//
//			if ($processed != '')
//				$category->intro = $processed;
//XI Parser
//			$processed = preg_replace('#\\\\\"#Uis', '"', $category->title);
//
//			if ($processed != '')
//				$category->title = $processed;
//XII parser
			$processed = preg_replace('#href=\"http:\/\/new\.universalpath\.org\/article\/([0-9]+)\"#Uis', 'href="/article/$1"', $category->intro);

			if ($processed != null && strlen($processed) > 0)
				$category->intro = $processed;
//XIII Parser
			$processed = preg_replace('#href=\"http:\/\/new\.universalpath\.org\/category\/([0-9]+)\"#Uis', 'href="/category/$1"', $category->intro);

			if ($processed != null && strlen($processed) > 0)
				$category->intro = $processed;

			if (!$category->Save())
				Quark::Log('Cannot save category:' . $category->id);
		}

		return QuarkDTO::ForRedirect('/admin/category/list');
	}
}
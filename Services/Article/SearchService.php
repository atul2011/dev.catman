<?php

namespace Services\Article;

use Models\Article;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Behaviors\AuthorizationBehavior;

class SearchService implements IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkCollection|Article[] $articles
		 */
		$articles = QuarkModel::Find(new Article());
		$out = new QuarkCollection(new Article());
		$limit = 10;
		if (isset($request->limit)) $limit = $request->limit;
		$i = $limit;
		foreach ($articles as $article) {
			if ($i > 0) {
				if (preg_match('#.*' . $request->title . '.*#Uis', $article->title) > 0) {
					$out[] = $article;
					--$i;
				}
			}
			else {
				Quark::Trace($i);
				break;
			}
		}

		return array(
			'status' => 200,
			'response' => $out->Extract(array(
				'id',
				'title',
				'release_date',
				'event_id',
				'txtfield'
			)
			));
	}

	/**
	 * @param QuarkDTO $request
	 *
	 * @return IQuarkIOProcessor
	 */
	public function Processor (QuarkDTO $request) {
		return new QuarkJSONIOProcessor();
	}
}
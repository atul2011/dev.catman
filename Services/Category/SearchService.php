<?php

namespace Services\Category;

use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Behaviors\AuthorizationBehavior;

class SearchService implements IQuarkServiceWithCustomProcessor, IQuarkPostService,IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkCollection|Category[] $categories
		 */
		$categories = QuarkModel::Find(new Category());
		$out = new QuarkCollection(new Category());
		$limit = 0;
		if (isset($request->limit)) $limit = $request->limit;
		$i = $limit;
		foreach ($categories as $category) {
			if ($i > 0) {
				if (preg_match('#.*' . $request->title . '.*#Uis', $category->title) > 0) {
					$out[] = $category;
					--$i;
				}
			}else{
				break;
			}
		}

		return array(
			'status' => 200,
			'response' => $out->Extract(array(
				'id',
				'title',
				'sub',
				'intro'
			), array(), array(
					QuarkModel::OPTION_LIMIT => 100
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
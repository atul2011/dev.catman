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

class SearchService implements IQuarkServiceWithCustomProcessor, IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication {
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
		$limit = 50;

		$out = $categories->Select(
			array('title' => array('$regex' => '#.*' . $request->title . '.*#Uis')),
			array(QuarkModel::OPTION_LIMIT => $limit)
		);

		return array(
			'status' => 200,
			'response' => $out->Extract(array(
				'id',
				'title',
				'sub',
				'intro'
			)));
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
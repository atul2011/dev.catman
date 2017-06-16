<?php

namespace Services\Author;

use Models\Author;
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
		 * @var QuarkCollection|Author[] $author
		 */
		$author = QuarkModel::Find(new Author());
		$out = new QuarkCollection(new Author());
		$limit = 50;
		if (isset($request->limit)) $limit = $request->limit;
		$i = $limit;
		foreach ($author as $item) {
			if ($i > 0) {
				if (preg_match('#.*' . $request->name . '.*#Uis', $item->name) > 0) {
					$out[] = $item;
					--$i;
				}
			}
			else {
				break;
			}
		}

		return array(
			'status' => 200,
			'response' => $out->Extract(array(
				'id',
				'name',
				'type',
				'keywords'
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
<?php

namespace Services\Author;

use Models\Author;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Behaviors\AuthorizationBehavior;
use Services\Behaviors\CustomProcessorBehavior;

class SearchService implements IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;

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
		$limit = 50;
		$skip = 0;
		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;
		if (isset($request->skip) && ($request->skip !== null))
			$skip = $request->skip;
		$author = QuarkModel::Find(new Author());
		$out = $author->Select(
			array($request->Data()->field => array('$regex' => '#.*' . $request->Data()->value . '.*#Uis')),
			array(
				QuarkModel::OPTION_LIMIT => $limit,
				QuarkModel::OPTION_SKIP => $skip
			)
		);

		return array(
			'status' => 200,
			'response' => $out->Extract(array(
				'id',
				'name',
				'type',
				'keywords'
			))
//		, 'number' => $out->Count()
		);
	}
}
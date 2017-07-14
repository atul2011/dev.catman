<?php

namespace Services\Admin\News;
use Models\News;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

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
		 * @var QuarkCollection|News[] $news
		 */
		$limit = 50;
		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;
		$news= QuarkModel::Find(new News());
		$out = $news->Select(
			array($request->Data()->field => array('$regex' => '#.*' . $request->Data()->value . '.*#Uis')),
			array(
				QuarkModel::OPTION_LIMIT => $limit
			)
		);

		return array(
			'status' => 200,
			'response' => $out->Extract(array(
					'id',
					'title',
					'type',
					'text',
					'publish_date',
					'link_url',
					'link_text',
					'lastediteby_userid',
					'lastedited_date'
				))
		);
	}
}
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

/**
 * Class SearchService
 *
 * @package Services\Admin\News
 */
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

		if ($request->field == 'id' && is_numeric($request->field)) {
			/**
			 * @var QuarkModel|News $news
			 */
			$news = QuarkModel::FindOneById(new News(), $request->value);
			$out = array();

			if ($news != null)
				$out[] = $news->Extract(array(
                    'id',
                    'title',
                    'type',
                    'publish_date',
                    'link_url',
                    'link_text',
                    'lastediteby_userid'
                ));

			return array(
				'status' => 200,
				'response' => $out
			);
		}
		$news = QuarkModel::Find(new News(), array(
				$request->field => array('$regex' => '#.*' . $request->value . '.*#Uisu')),
			array(QuarkModel::OPTION_LIMIT => $limit)
		);

		return array(
			'status' => 200,
			'response' => $news->Extract(array(
					'id',
					'title',
					'type',
					'publish_date',
					'link_url',
					'link_text',
					'lastediteby_userid'
				))
		);
	}
}
<?php
namespace Services\Admin\News;

use Models\News;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;
use ViewModels\Admin\News\ListView;

/**
 * Class ListService
 *
 * @package Services\Admin\News
 */
class ListService implements IQuarkGetService, IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new ListView(), new QuarkPresenceControl(), array('number' => QuarkModel::Count(new News())));
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		$limit = 50;
		$skip = 0;

		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;

		if (isset($request->skip) && ($request->skip !== null))
			$skip = $request->skip;
		/**
		 * @var QuarkCollection|News[] $news
		 */
		$news = QuarkModel::Find(new News(), array(), array(
			QuarkModel::OPTION_LIMIT => $limit,
			QuarkModel::OPTION_SKIP => $skip
		));

		foreach ($news as $item)
			$item->RevealAll();

		return array(
			'status' => 200,
			'response' => $news->Extract(array(
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
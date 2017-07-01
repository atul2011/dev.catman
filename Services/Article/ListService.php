<?php

namespace Services\Article;

use Models\Article;
use Models\Articles_has_Categories;
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
use Services\Behaviors\AuthorizationBehavior;
use Services\Behaviors\CustomProcessorBehavior;
use ViewModels\Content\Article\ListView;

/**
 * Class ListService
 *
 * @package Services\Articles
 */
class ListService implements IQuarkPostService, IQuarkGetService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new ListView(), new QuarkPresenceControl(),array(
			'number'=>QuarkModel::Count(new Article())
		));
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkCollection|Article[] $article
		 * @var QuarkCollection|Articles_has_Categories $links
		 */
		$limit = 50;
		$skip = 0;
		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;
		if (isset($request->skip) && ($request->skip !== null))
			$skip = $request->skip;

		$article = QuarkModel::Find(new Article(), array(), array(
			QuarkModel::OPTION_LIMIT => $limit,
			QuarkModel::OPTION_SKIP => $skip
		));
		$orfans = new QuarkCollection(new Article());

		//define variables that we will get from page.if not we will define default values
		$model = 'article';
		$orfan = false;
		if (isset($request->Data()->orfan) && $request->Data()->orfan !== null) $orfan = $request->Data()->orfan;
		if (isset($request->Data()->model) && $request->Data()->model !== null) $model = $request->Data()->model;
		//if is another model, go out
		if ($model !== 'none' && $model !== 'article') {
			return array(
				'status' => 200,
				'response' => null
			);
			//if is roght model and want orfans, we give orfans
		}
		elseif ($orfan === 'true' && $model === 'article') {
			foreach ($article as $item) {
				$links = QuarkModel::Count(new Articles_has_Categories(), array(
					'article_id' => $item->id
				));
				if ($links == 0) $orfans[] = $item;
			}
			//if is not another model, and do not want orfans, we not gice orfans
		}
		elseif ($orfan === 'false' && ($model === 'none' || $model === 'article')) {
			$orfans = $article;
		}

		return array(
			'status' => 200,
			'response' => $orfans->Extract(array(
					'id',
					'title',
					'release_date',
					'event_id',
					'txtfield'
				)
			), 'items' => $orfans->Count()
		);
	}
}
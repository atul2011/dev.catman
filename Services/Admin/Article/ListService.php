<?php
namespace Services\Admin\Article;

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
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;
use ViewModels\Admin\Article\ListView;

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
		return QuarkView::InLayout(new ListView(), new QuarkPresenceControl(), array('number' => QuarkModel::Count(new Article())));
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkCollection|Article[] $articles
		 * @var QuarkCollection|Articles_has_Categories $links
		 */
		$limit = 50;
		$skip = 0;

		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;

		if (isset($request->skip) && ($request->skip !== null))
			$skip = $request->skip;

		$articles = QuarkModel::Find(new Article(), array(), array(
			QuarkModel::OPTION_LIMIT => $limit,
			QuarkModel::OPTION_SKIP => $skip
		));

		$orfans = new QuarkCollection(new Article());

		//define variables that we will get from page.if not we will define default values
		$model = 'article';
		$orfan = false;

		if (isset($request->Data()->orfan) && $request->Data()->orfan !== null)
			$orfan = $request->Data()->orfan;

		if (isset($request->Data()->model) && $request->Data()->model !== null)
			$model = $request->Data()->model;

		if ($model !== 'none' && $model !== 'article') {//if is another model, go out
			return array(
				'status' => 200,
				'response' => null
			);
		}
		elseif ($orfan === 'true' && $model === 'article') {//if is roght model and want orfans, we give orfans
			foreach ($articles as $item) {
				$item->RevealAll();
				$links = QuarkModel::Count(new Articles_has_Categories(), array('article_id' => $item->id));

				if ($links == 0)
					$orfans[] = $item;
			}
		}
		elseif ($orfan === 'false' && ($model === 'none' || $model === 'article')) {//if is not another model, and do not want orfans, we not give orfans
			foreach ($articles as $item) {
				$item->RevealAll();
				$orfans[] = $item;
			}
		}

		return array(
			'status' => 200,
			'response' => $orfans->Extract(array(
	               'id',
	               'title',
	               'release_date',
	               'event_id'
	           )),
			'items' => $orfans->Count()
		);
	}
}
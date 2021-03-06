<?php
namespace Services\Admin\Category;

use Models\Category;
use Models\Categories_has_Categories;
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
use ViewModels\Admin\Category\ListView;

/**
 * Class ListService
 *
 * @package Services\Categories
 */
class ListService implements IQuarkGetService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication, IQuarkPostService {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new ListView(), new QuarkPresenceControl(), array('number' => QuarkModel::Count(new Category())));
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkCollection|Category[] $categories
		 * @var QuarkCollection|Categories_has_Categories[] $status
		 */
		$limit = 50;
		$skip = 0;

		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;

		if (isset($request->skip) && ($request->skip !== null))
			$skip = $request->skip;

		$categories = QuarkModel::Find(new Category(), array(), array(
			QuarkModel::OPTION_LIMIT => $limit,
			QuarkModel::OPTION_SKIP => $skip
		));

		$orfans = new QuarkCollection(new Category());

		//define variables that we will get from page.if not we will define default values
		$model = 'category';
		$orfan = false;

		if (isset($request->Data()->orfan))
			$orfan = $request->Data()->orfan;

		if (isset($request->Data()->model))
			$model = $request->Data()->model;

		if ($model !== 'none' && $model !== 'category') {//if is another model, go out
			return array(
				'status' => 200,
				'response' => null
			);
		}
		elseif ($orfan === 'true' && $model === 'category') {//if is roght model and want orfans, we give orfans
			foreach ($categories as $item) {
				$status = QuarkModel::Count(new Categories_has_Categories(), array('child_id1' => $item->id));

				if ($status == 0)
					$orfans[] = $item;
			}
		}
		elseif ($orfan === 'false' && $model === 'none' || $model === 'category') {//if is not another model, and do not want orfans, we not give orfans
			$orfans = $categories;
		}

		return array(
			'status' => 200,
			'response' => $orfans->Extract(array(
				'id',
				'title',
				'sub',
		        'has_links'
			))
		);
	}
}
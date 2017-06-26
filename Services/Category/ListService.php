<?php

namespace Services\Category;

use Models\Category;
use Models\Categories_has_Categories;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
<<<<<<< HEAD
use Quark\IQuarkIOProcessor;
=======
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
<<<<<<< HEAD
use Quark\QuarkJSONIOProcessor;
=======
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Behaviors\AuthorizationBehavior;
<<<<<<< HEAD
=======
use Services\Behaviors\CustomProcessorBehavior;
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
use ViewModels\Content\Category\ListView;

/**
 * Class ListService
 *
 * @package Services\Categories
 */
<<<<<<< HEAD
class ListService implements IQuarkGetService, IQuarkServiceWithCustomProcessor,IQuarkAuthorizableServiceWithAuthentication,IQuarkPostService {
	use AuthorizationBehavior;
=======
class ListService implements IQuarkGetService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication, IQuarkPostService {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkCollection|Category[] $category
		 * @var QuarkCollection|Categories_has_Categories[] $status
		 */
<<<<<<< HEAD

		$category = QuarkModel::Find(new Category(), array(), array(
			QuarkModel::OPTION_LIMIT => 50
		));
=======
		$limit = 50;
		$skip = 0;
		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;
		if (isset($request->skip) && ($request->skip !== null))
			$skip = $request->skip;
		$category = QuarkModel::Find(new Category(), array(), array(
			QuarkModel::OPTION_LIMIT => $limit,
			QuarkModel::OPTION_SKIP => $skip
		));

>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
		$orfans = new QuarkCollection(new Category());
		//define variables that we will get from page.if not we will define default values
		$model = 'category';
		$orfan = false;
		if (isset($request->Data()->orfan)) $orfan = $request->Data()->orfan;
		if (isset($request->Data()->model)) $model = $request->Data()->model;
		//if is another model, go out
		if ($model !== 'none' && $model !== 'category') {
			return array(
				'status' => 200,
				'response' => null
			);
			//if is roght model and want orfans, we give orfans
		}
		elseif ($orfan === 'true' && $model === 'category') {
			foreach ($category as $item) {
				$status = QuarkModel::Count(new Categories_has_Categories(), array(
					'child_id1' => $item->id
				));
				if ($status == 0) $orfans[] = $item;
			}
			//if is not another model, and do not want orfans, we not gice orfans
		}
		elseif ($orfan === 'false' && $model === 'none' || $model === 'category') {
			$orfans = $category;
		}
<<<<<<< HEAD
=======

>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
		return array(
			'status' => 200,
			'response' => $orfans->Extract(array(
					'id',
					'title',
					'sub',
					'intro'
				)
<<<<<<< HEAD
			));
=======
			)
//		, 'number' =>$category->Count()
		);
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
<<<<<<< HEAD
		return QuarkView::InLayout(new ListView(),new QuarkPresenceControl());
	}

	/**
	 * @param QuarkDTO $request
	 *
	 * @return IQuarkIOProcessor
	 */
	public function Processor (QuarkDTO $request) {
		return new QuarkJSONIOProcessor();
=======
		return QuarkView::InLayout(new ListView(), new QuarkPresenceControl(), array(
			'number' => QuarkModel::Count(new Category())
		));
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
	}
}
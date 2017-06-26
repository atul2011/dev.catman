<?php

namespace Services\Author;

use Models\Author;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
<<<<<<< HEAD
use Quark\IQuarkIOProcessor;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
=======
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
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
use ViewModels\Content\Author\ListView;

class ListService implements IQuarkGetService, IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
<<<<<<< HEAD
=======
	use CustomProcessorBehavior;
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
<<<<<<< HEAD
		return QuarkView::InLayout(new ListView(), new QuarkPresenceControl());
=======
		return QuarkView::InLayout(new ListView(), new QuarkPresenceControl(), array(
			'number' => QuarkModel::Count(new Author())
		));
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
<<<<<<< HEAD
		 * @var QuarkModel|Author $author
		 */
		$author = QuarkModel::Find(new Author(), array(), array(
			QuarkModel::OPTION_LIMIT => 50
=======
		 * @var QuarkCollection|Author $author
		 */
		$limit = 50;
		$skip = 0;
		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;
		if (isset($request->skip) && ($request->skip !== null))
			$skip = $request->skip;
		$author = QuarkModel::Find(new Author(), array(), array(
			QuarkModel::OPTION_LIMIT => $limit,
			QuarkModel::OPTION_SKIP => $skip
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
		));
		$model = 'author';
		if (isset($request->Data()->model) && $request->Data()->model !== null) $model = $request->Data()->model;
		//if is another model, go out
		if ($model !== 'author') {
			return array(
				'status' => 200,
				'response' => null
			);
		}
		return array(
			'status' => 200,
			'response' => $author->Extract(array(
<<<<<<< HEAD
					'id',
					'name',
					'type',
					'keywords'
				)
			));
	}

	/**
	 * @param QuarkDTO $request
	 *
	 * @return IQuarkIOProcessor
	 */
	public function Processor (QuarkDTO $request) {
		return new QuarkJSONIOProcessor();
=======
				'id',
				'name',
				'type',
				'keywords'
			))
//		   , 'number' => $author->Count()
		);
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
	}
}
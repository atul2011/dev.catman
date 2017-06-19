<?php

namespace Services\Author;

use Models\Author;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Behaviors\AuthorizationBehavior;
use Services\Behaviors\CustomProcessorBehavior;
use ViewModels\Content\Author\ListView;

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
		return QuarkView::InLayout(new ListView(), new QuarkPresenceControl());
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Author $author
		 */
		$author = QuarkModel::Find(new Author(), array(), array(
			QuarkModel::OPTION_LIMIT => 50,
			QuarkModel::OPTION_SKIP =>$request->skip
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
					'id',
					'name',
					'type',
					'keywords'
				)
			));
	}
}
<?php
namespace Services\Admin\Author;

use Models\Author;
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
use ViewModels\Admin\Author\ListView;

/**
 * Class ListService
 *
 * @package Services\Admin\Author
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
		return QuarkView::InLayout(new ListView(), new QuarkPresenceControl(), array('number' => QuarkModel::Count(new Author())));
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkCollection|Author $authors
		 */
		$limit = 50;
		$skip = 0;

		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;

		if (isset($request->skip) && ($request->skip !== null))
			$skip = $request->skip;

		$authors = QuarkModel::Find(new Author(), array(), array(
			QuarkModel::OPTION_LIMIT => $limit,
			QuarkModel::OPTION_SKIP => $skip
		));

		return array(
			'status' => 200,
			'response' => $authors->Extract(array(
				'id',
				'name',
				'type',
				'keywords'
			))
		);
	}
}
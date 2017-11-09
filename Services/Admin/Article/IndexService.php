<?php
namespace Services\Admin\Article;

use Models\Article;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;
use ViewModels\Admin\Status\BadRequestView;

/**
 * Class IndexService
 *
 * @package Services\Articles
 */
class IndexService implements IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication, IQuarkServiceWithCustomProcessor {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		if ($request->URI()->Route(2) == '')
			return QuarkView::InLayout(new BadRequestView(), new QuarkPresenceControl());


		return array(
			'status' => 200,
			'item' => QuarkModel::FindOneById(new Article(), $request->URI()->Route(2))->Extract(
				array(
					'id',
					'title'
				)
			)
		);
	}
}
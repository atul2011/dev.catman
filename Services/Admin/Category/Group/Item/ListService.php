<?php
namespace Services\Admin\Category\Group\Item;

use Models\CategoryGroup;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class CreateService
 *
 * @package Services\Admin\Category\Group\Item
 */
class ListService implements IQuarkPostService,IQuarkAuthorizableServiceWithAuthentication, IQuarkServiceWithCustomProcessor {
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
		 * @var QuarkModel|CategoryGroup $group
		 */
		$group = QuarkModel::FindOneById(new CategoryGroup(), $request->URI()->Route(5));

		if ($group != null)
			return array('status' => 400);

		return array(
			'status' => 200,
		    'items' => $group->Items()
		);
	}
}
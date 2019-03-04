<?php
namespace Services\Admin\Category\Group;

use Models\CategoryGroup;
use Models\CategoryGroupItem;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class DeleteService
 *
 * @package Services\Admin\Category\Group
 */
class DeleteService implements IQuarkGetService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|CategoryGroup $group
		 */
		$group = QuarkModel::FindOneById(new CategoryGroup(), $request->URI()->Route(4));

		if ($group == null)
			return array('status' => 404);
		/**
		 * @var QuarkCollection|CategoryGroupItem[] $items
		 */
		$items = $group->Items();

		foreach ($items as $item) {
			if (!$item->Remove())
				return array(
					'status' => 500,
					'errors' => array('Cannot delete group item of group:' . $group->id)
				);
		}

		if (!$group->Remove())
			return array('status' => 500);

		return array('status' => 200);
	}
}
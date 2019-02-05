<?php
namespace Services\Admin\Category\Group\Item;

use Models\CategoryGroupItem;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class DeleteService
 *
 * @package Services\Admin\Category\Group\Item
 */
class DeleteService implements IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
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
		 * @var QuarkModel|CategoryGroupItem $item
		 */
		$item = QuarkModel::FindOne(new CategoryGroupItem(), array(
			'category_group' => $request->group,
			'target' => $request->target,
		    'type' => $request->type
		));

		if ($item == null)
			return array('status' => 404);

		if (!$item->Remove())
			return array('status' => 500);

		return array('status' => 200);
	}
}
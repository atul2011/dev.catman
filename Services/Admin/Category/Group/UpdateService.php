<?php
namespace Services\Admin\Category\Group;

use Models\Category;
use Models\CategoryGroup;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\Quark;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class UpdateService
 *
 * @package Services\Admin\Category\Group
 */
class UpdateService implements IQuarkPostService,IQuarkAuthorizableServiceWithAuthentication, IQuarkServiceWithCustomProcessor {
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
		$group = QuarkModel::FindOneById(new CategoryGroup(), $request->URI()->Route(4));

		if ($group == null)
			return array('status' => 404);

		if (isset($request->title))
			$group->title = htmlspecialchars($request->title);

		if (isset($request->description))
			$group->description = htmlspecialchars($request->description);

		if (isset($request->priority))
			$group->priority = (int)htmlspecialchars(trim($request->priority));

		if (!$group->Save())
			return array('status' => 500);

		return array(
			'status' => 200,
		    'group' => $group->Extract()
		);
	}
}
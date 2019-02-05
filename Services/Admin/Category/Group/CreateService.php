<?php
namespace Services\Admin\Category\Group;

use Models\Category;
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
 * @package Services\Admin\Category\Group
 */
class CreateService implements IQuarkPostService,IQuarkAuthorizableServiceWithAuthentication, IQuarkServiceWithCustomProcessor {
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
		 * @var QuarkModel|Category $category
		 */
		$category = QuarkModel::FindOneById(new Category(), $request->URI()->Route(4));

		if ($category == null)
			return array('status' => 400);

		/**
		 * @var QuarkModel|CategoryGroup $group
		 */
		$group = new QuarkModel(new CategoryGroup(), array(
			'category' => $category
		));

		if (isset($request->title))
			$group->title = htmlspecialchars($request->title);

		if (isset($request->description))
			$group->description = htmlspecialchars($request->description);

		if (!$group->Create())
			return array('status' => 500);

		return array(
			'status' => 200,
		    'group' => $group->Extract()
		);
	}
}
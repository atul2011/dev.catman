<?php
namespace Services\Admin\Category\Group;

use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\Category\Group\IndexView;
use ViewModels\Admin\Status\ConflictView;

/**
 * Class IndexService
 *
 * @package Services\Categories
 */
class IndexService implements IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Category $category
		 */
		$category = QuarkModel::FindOneById(new Category(), $request->URI()->Route(3));

		if ($category == null)
			return QuarkView::InLayout(new ConflictView(), new QuarkPresenceControl());

		return QuarkView::InLayout(new IndexView(), new QuarkPresenceControl(), array('category' => $category));
	}
}
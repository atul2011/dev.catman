<?php
namespace Services\Admin\Category;

use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;

/**
 * Class SstService
 *
 * @package Services\Admin\Category
 */
class RepairService implements IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkCollection|Category[] $categories
		 */
		$categories = QuarkModel::Find(new Category());

		foreach ($categories as $category) {
//			$category->short_title = $category->title;
			$category->available_on_site = true;

			if (!$category->Save())
				Quark::Log('Cannot save category:' . $category->id);
		}

		return QuarkDTO::ForRedirect('/admin/category/list');
	}
}
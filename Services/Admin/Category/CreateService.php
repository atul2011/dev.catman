<?php
namespace Services\Admin\Category;

use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\Category\CreateView;
use ViewModels\Admin\Status\BadRequestView;
use ViewModels\Admin\Status\ConflictView;
use ViewModels\Admin\Status\CustomErrorView;
use ViewModels\Admin\Status\InternalServerErrorView;

/**
 * Class CreateService
 *
 * @package Services\Category
 */
class CreateService implements IQuarkPostService, IQuarkGetService,IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new CreateView(), new QuarkPresenceControl());
	}

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
		$category = QuarkModel::FindOne(new Category(), array('title' => $request->Data()->title));

		if ($category != null)//ceck if category is already exist
			return QuarkView::InLayout(new ConflictView(), new QuarkPresenceControl());

		$category = new QuarkModel(new Category(), $request->Data());

		if ($category->role == Category::ROLE_SYSTEM) {//check if admin want to create an system category
			if ($category->sub == Category::TYPE_SYSTEM_ROOT_CATEGORY) {//check if admin want to create an root system category
				if (Category::RootCategory() == null)
					return QuarkView::InLayout(new CustomErrorView(), new QuarkPresenceControl(), array(
						'error_status' => 'Status 409: Conflict',
						'error_message' => 'Cannot crete more than 2 root categories!'
					));
			}
			else if ($category->sub == Category::TYPE_SYSTEM_TOP_MENU_CATEGORY) {//check if admin want to create an root system category
				if (Category::TYPE_SYSTEM_TOP_MENU_CATEGORY == null)
					return QuarkView::InLayout(new CustomErrorView(), new QuarkPresenceControl(), array(
						'error_status' => 'Status 409: Conflict',
						'error_message' => 'Cannot crete more than 2 top menu categories!'
					));
			}
			else if ($category->sub == Category::TYPE_SYSTEM_MAIN_MENU_CATEGORY) {//check if admin want to create an root system category
				if (Category::TYPE_SYSTEM_MAIN_MENU_CATEGORY == null)
					return QuarkView::InLayout(new CustomErrorView(), new QuarkPresenceControl(), array(
						'error_status' => 'Status 409: Conflict',
						'error_message' => 'Cannot crete more than 2 main menu categories!'
					));
			}
			else if ($category->sub == Category::TYPE_SYSTEM_BOTTOM_MENU_CATEGORY) {//check if admin want to create an root system category
				if (Category::TYPE_SYSTEM_BOTTOM_MENU_CATEGORY == null)
					return QuarkView::InLayout(new CustomErrorView(), new QuarkPresenceControl(), array(
						'error_status' => 'Status 409: Conflict',
						'error_message' => 'Cannot crete more than 2 bottom menu categories!'
					));
			}
		}

		$category->available_on_site = !isset($request->available_on_site) ? false : true;
		$category->available_on_api = !isset($request->available_on_api) ? false : true;

		if (!$category->Validate())
			return QuarkView::InLayout(new BadRequestView(), new QuarkPresenceControl());

		if (!$category->Create())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect('/admin/category/list');
	}
}
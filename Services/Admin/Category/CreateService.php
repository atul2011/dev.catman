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
use ViewModels\Admin\Content\Category\CreateView;

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
		//ceck if category is already exist
		$category = QuarkModel::FindOne(new Category(), array(
			'title' => $request->Data()->title
		));
		if ($category != null)
			return QuarkDTO::ForStatus(QuarkDTO::STATUS_500_SERVER_ERROR);
		$category = new QuarkModel(new Category(), $request->Data());

		//set tags
		$request->Data()->tag_list != '' ? $tags  = explode(',',$request->Data()->tag_list)
										 : $tags  = array();

		$category->setTags($tags);

		if (!$category->Create())
			return QuarkDTO::ForStatus(QuarkDTO::STATUS_500_SERVER_ERROR);

		return QuarkDTO::ForRedirect('/admin/category/list?created=true');
	}
}
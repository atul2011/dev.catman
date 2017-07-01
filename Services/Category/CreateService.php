<?php

namespace Services\Category;

use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Behaviors\AuthorizationBehavior;
use Services\Behaviors\CustomProcessorBehavior;
use ViewModels\Content\Category\CreateView;

/**
 * Class CreateService
 *
 * @package Services\Category
 */
class CreateService implements IQuarkServiceWithCustomProcessor, IQuarkPostService, IQuarkGetService,IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;

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
		 * @var QuarkCollection|Category $categories
		 */
		//ceck if category is already exist
		$category = QuarkModel::FindOne(new Category(), array(
			'title' => $request->Data()->title
		));
		if ($category != null)
			return QuarkDTO::ForStatus(QuarkDTO::STATUS_500_SERVER_ERROR);
		$category = new QuarkModel(new Category(), $request->Data());
		if (!$category->Create())
			return QuarkDTO::ForStatus(QuarkDTO::STATUS_500_SERVER_ERROR);

		return QuarkDTO::ForRedirect('/category/list?created=true');
	}
}
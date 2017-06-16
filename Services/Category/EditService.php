<?php

namespace Services\Category;

use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Behaviors\AuthorizationBehavior;
use ViewModels\Content\Category\CreateView;

class EditService implements IQuarkPostService, IQuarkGetService, IQuarkServiceWithCustomProcessor,IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new CreateView(), new QuarkPresenceControl(), array(
			'category' => QuarkModel::FindOneById(new Category(), $request->URI()->Route(2))
		));
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *s
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Category $category
		 */
		$id = $request->URI()->Route(2);
		$category = QuarkModel::FindOneById(new Category(),$id );
		if ($category === null) return QuarkDTO::ForStatus(QuarkDTO::STATUS_404_NOT_FOUND);
		$category->PopulateWith($request->Data());
		if (!$category->Save())
			return QuarkDTO::ForStatus(QuarkDTO::STATUS_500_SERVER_ERROR);

		if(isset($request->source) && $request->source === 'EditContent')
			return QuarkDTO::ForRedirect('/category/list/'.$id.'?edited=true');

		return QuarkDTO::ForRedirect('/admin/categories?edited=category');
	}

	/**
	 * @param QuarkDTO $request
	 *
	 * @return IQuarkIOProcessor
	 */
	public function Processor (QuarkDTO $request) {
		return new QuarkJSONIOProcessor();
	}
}
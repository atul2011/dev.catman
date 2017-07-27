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
use ViewModels\Admin\Content\Category\EditView;
use ViewModels\Admin\Status\NotFoundView;

class EditService implements IQuarkPostService, IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
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
		$id = $request->URI()->Route(3);
		if(!is_numeric($id))
			return QuarkView::InLayout(new NotFoundView(),new QuarkPresenceControl(),array(
				'model' => 'Category'
			));

		$category = QuarkModel::FindOneById(new Category(),$id);

		if($category == null)
			return QuarkView::InLayout(new NotFoundView(),new QuarkPresenceControl(),array(
				'model' => 'Category'
			));


		return QuarkView::InLayout(new EditView(), new QuarkPresenceControl(), array(
			'category' => $category->Extract(),
			'tags' => $category->getTags()->Extract()
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
		$id = $request->URI()->Route(3);
		$category = QuarkModel::FindOneById(new Category(),$id );

		if ($category === null) return QuarkDTO::ForStatus(QuarkDTO::STATUS_404_NOT_FOUND);

		$category->PopulateWith($request->Data());
		$request->Data()->tag_list != '' ? $tags = explode(',', $request->Data()->tag_list)
										 : $tags = array();

		$category->setTags($tags);

		if (!$category->Save())
			return QuarkDTO::ForRedirect('/admin/category/list?update=false');

		if(isset($request->source) && $request->source === 'EditContent')
			return QuarkDTO::ForRedirect('/admin/category/list/'.$id.'?edited=true');

		return QuarkDTO::ForRedirect('/admin/structures/categories?edited=category');
	}
}
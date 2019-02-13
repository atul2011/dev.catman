<?php
namespace Services\Admin\Category;

use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class ChildesService
 *
 * @package Services\Admin\Category
 */
class ChildesService implements IQuarkGetService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;

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
			return array('status' => 404);

		return array(
			'status' => 200,
			'articles' => $category->Articles()->Extract(array(
					'id',
					'title',
					'runtime_priority',
					'runtime_category',
					'runtime_link',
			        'grouped'
				)
			),
			'categories' => $category->ChildCategories()->Extract(array(
					'id',
					'title',
					'runtime_priority',
					'runtime_category',
					'runtime_link',
					'grouped'
				)
			)
		);
	}
}
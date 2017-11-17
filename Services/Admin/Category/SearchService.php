<?php
namespace Services\Admin\Category;

use Models\Category;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class SearchService
 *
 * @package Services\Admin\Category
 */
class SearchService implements IQuarkServiceWithCustomProcessor, IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication {
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
		 * @var QuarkCollection|Category[] $categories
		 */
		$limit = 50;

		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;

		if ($request->field == 'id' && is_numeric((int)$request->field))
			return array(
				'status' => 200,
				'response' => array(QuarkModel::FindOneById(new Category(), $request->value)->Extract(array(
                      'id',
                      'title',
                      'sub'
                 )))
			);

		$categories = QuarkModel::Find(new Category(), array(
				$request->Data()->field => array('$regex' => '#.*' . $request->Data()->value . '.*#Uisu')),
			array(QuarkModel::OPTION_LIMIT => $limit)
		);

		return array(
			'status' => 200,
			'response' => $categories->Extract(array(
				'id',
				'title',
				'sub'
			))
		);
	}
}
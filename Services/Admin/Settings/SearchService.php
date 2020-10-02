<?php
namespace Services\Admin\Settings;

use Models\Settings;
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
 * @package Services\Admin\Term
 */
class SearchService implements IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
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
		 * @var QuarkCollection|Term[] $terms
		 */
		$limit = 50;

		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;

		if ($request->field == 'id' && is_numeric($request->field)) {
			/**
			 * @var QuarkModel|Term $term
			 */
			$settings = QuarkModel::FindOneById(new Settings(), $request->value);
			$out = array();

			if ($settings != null)
				$out[] = $term->Extract();

			return array(
				'status' => 200,
				'response' => $out
			);
		}

		$settings = QuarkModel::Find(new Settings(), array(
				$request->field => array('$regex' => '#.*' . $request->value . '.*#Uisu')
			), array(QuarkModel::OPTION_LIMIT => $limit)
		);

		return array(
			'status' => 200,
			'response' => $terms->Extract()
		);
	}
}

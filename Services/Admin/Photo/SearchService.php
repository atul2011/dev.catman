<?php
namespace Services\Admin\Photo;

use Models\Photo;
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
 * @package Services\Admin\Photo
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
		$limit = 50;

		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;

		if ($request->field == 'id' && is_numeric($request->field)) {
			/**
			 * @var QuarkModel|Photo $photo
			 */
			$photo = QuarkModel::FindOneById(new Photo(), $request->value);
			$out = new QuarkCollection(new Photo());

			if ($photo != null)
				$out[] = $photo->Extract();

			return array(
				'status' => 200,
				'response' => $out
			);
		}

		/**
		 * @var QuarkCollection|Photo[] $photos
		 */
		$photos = QuarkModel::Find(new Photo(), array(
				$request->Data()->field => array('$regex' => '#.*' . $request->Data()->value . '.*#Uisu')
			), array(QuarkModel::OPTION_LIMIT => $limit)
		);

		return array(
			'status' => 200,
			'response' => $photos->Extract()
		);
	}
}
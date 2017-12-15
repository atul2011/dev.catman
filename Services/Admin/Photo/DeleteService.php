<?php
namespace Services\Admin\Photo;

use Models\Photo;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class DeleteService
 *
 * @package Services\Admin\Photo
 */
class DeleteService implements IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication, IQuarkServiceWithCustomProcessor {
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
		 * @var QuarkModel|Photo $photo
		 */
		$photo = QuarkModel::FindOneById(new Photo(), $request->URI()->Route(3));

		if ($photo == null)
			return array('status' => 400);

		if(!$photo->Remove())
			return array('status' => 500);

		return array('status' => 200);
	}
}
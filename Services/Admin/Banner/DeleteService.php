<?php
namespace Services\Admin\Banner;

use Models\Banner;
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
 * @package Services\Admin\Banner
 */
class DeleteService implements IQuarkGetService ,IQuarkAuthorizableServiceWithAuthentication, IQuarkServiceWithCustomProcessor {
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
		 * @var QuarkModel|Banner $banner
		 */
		$banner = QuarkModel::FindOneById(new Banner(), $request->URI()->Route(3));

		if ($banner == null)
			return array('status' => 404);

		if(!$banner->Remove())
			return array('status' => 500);

		return array('status' => 200);
	}
}
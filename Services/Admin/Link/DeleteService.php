<?php
namespace Services\Admin\Link;

use Models\Link;
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
 * @package Services\Admin\Link
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
		 * @var QuarkModel|Link $link
		 */
		$link = QuarkModel::FindOneById(new Link(), $request->URI()->Route(3));

		if ($link == null)
			return array('status' => 400);

		if (!$link->Remove())
			return array('status' => 500);

		return array('status' => 200);
	}
}
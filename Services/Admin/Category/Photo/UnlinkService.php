<?php
namespace Services\Admin\Category\Photo;

use Models\Category_has_Photo;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class UnlinkService
 *
 * @package Services\Admin\Category\Photo
 */
class UnlinkService implements IQuarkGetService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
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
		 * @var QuarkModel|Category_has_Photo $link
		 */
		$link = QuarkModel::FindOneById(new Category_has_Photo(), $request->URI()->Route(4));

		if ($link == null)
			return array('status' => 404);

		return array('status' => $link->Remove() ? 200 : 500);
	}
}
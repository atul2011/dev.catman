<?php
namespace Services\Admin\Photo\Tag;

use Models\Photo_has_Tag;
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
 * @package Services\Admin\Photo\Tag
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
		 * @var QuarkModel|Photo_has_Tag $link
		 */
		$link = QuarkModel::FindOneById(new Photo_has_Tag(), $request->URI()->Route(4));

		if ($link == null)
			return array('status' => 404);

		return array('status' => $link->Remove() ? 200 : 500);
	}
}
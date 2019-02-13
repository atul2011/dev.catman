<?php
namespace Services\Admin\News;

use Models\News;
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
 * @package Services\Admin\News
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
		 * @var QuarkModel|News $news
		 */
		$news = QuarkModel::FindOneById(new News(), $request->URI()->Route(3));

		if ($news == null)
			return array('status' => 404);

		if(!$news->Remove())
			return array('status' => 500);

		return array('status' => 200);
	}
}
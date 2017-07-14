<?php
/**
 * Created by PhpStorm.
 * User: boagh
 * Date: 11.07.2017
 * Time: 16:55
 */

namespace Services\Admin\News;
use Models\News;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

class DeleteService implements IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
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
		 * @var QuarkModel|News $news
		 */
		$id = $request->URI()->Route(3);
		$news = QuarkModel::FindOneById(new News(), $id);
		if (!$news->Remove())
			return QuarkDTO::ForRedirect('/admin/news/list?deleted=false');
		return QuarkDTO::ForRedirect('/admin/news/list?deleted=true');
	}
}
<?php

namespace Services\Admin\News;
use Models\News;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;

class DeleteService implements IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

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
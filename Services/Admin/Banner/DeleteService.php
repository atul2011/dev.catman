<?php

namespace Services\Admin\Banner;
use Models\Banner;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\Status\NotFoundView;

class DeleteService implements IQuarkPostService ,IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Banner $banner
		 */
		$banner = QuarkModel::FindOneById(new Banner(), $request->URI()->Route(3));

		if($banner == null)
			return QuarkView::InLayout(new NotFoundView(),new QuarkPresenceControl(),array(
				'model' => 'Banner'
			));

		if(!$banner->Remove())
			return QuarkDTO::ForRedirect('/admin/banner/list?delete=false');

		return QuarkDTO::ForRedirect('/admin/banner/list?delete=true');
	}
}
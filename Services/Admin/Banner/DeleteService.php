<?php

namespace Services\Admin\Banner;
use Models\Banner;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;

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
			return QuarkDTO::ForRedirect('/admin/banner/list?status=404');

		if(!$banner->Remove())
			return QuarkDTO::ForRedirect('/admin/banner/list?delete=false');

		return QuarkDTO::ForRedirect('/admin/banner/list?delete=true');
	}
}
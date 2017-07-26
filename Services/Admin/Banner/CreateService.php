<?php

namespace Services\Admin\Banner;
use Models\Banner;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\Quark;
use Quark\QuarkDTO;
use Quark\QuarkFile;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\Content\Banner\CreateView;

class CreateService implements IQuarkPostService,IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new CreateView(),new QuarkPresenceControl());
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|QuarkFile $file
		 */
		$file = $request->file;

		$ok = $file->UploadTo(__DIR__ . '/../../../storage/banner/' . Quark::GuID());

		if (!$ok)
			return QuarkDTO::ForRedirect('/admin/banner/create?create=false');

		/**
		 * @var QuarkModel|Banner $banner
		 */
		$banner = new QuarkModel(new Banner(), $request->Data());
		$banner->file = $file;

		if (!$banner->Create())
			return QuarkDTO::ForRedirect('/admin/banner/create?create=false');

		return QuarkDTO::ForRedirect('/admin/banner/list?create=true');
	}
}
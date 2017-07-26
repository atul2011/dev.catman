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
use ViewModels\Admin\Content\Banner\EditView;

class EditService implements IQuarkGetService, IQuarkPostService ,IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		/**
		 *@var QuarkModel|Banner $banner
		 */
		$banner = QuarkModel::FindOneById(new Banner(),$request->URI()->Route(3));

		if($banner == null)
			return QuarkDTO::ForRedirect('/admin/banner/list?status=404');

		return QuarkView::InLayout(new EditView(),new QuarkPresenceControl(),array(
			'banner' => $banner->Extract()
		));
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		$id = $request->URI()->Route(3);

		/**
		 * @var QuarkModel|Banner $banner
		 */
		$banner = QuarkModel::FindOneById(new Banner(), $id);

		$banner->active = $request->active;
		/**
		 * @var QuarkModel|QuarkFile $file
		 */
		$file = $request->file;
		if($file->name  != '') {
			$ok = $file->UploadTo(__DIR__ . '/../../../storage/banner/' . Quark::GuID());

			if (!$ok)
				return QuarkDTO::ForRedirect('/admin/banner/edit/' . $id . '?edit=false');

			$banner->file = $file;
		}
		if (!$banner->Save())
			return QuarkDTO::ForRedirect('/admin/banner/list?edit=false');

		return QuarkDTO::ForRedirect('/admin/banner/list?edit=true');
	}
}
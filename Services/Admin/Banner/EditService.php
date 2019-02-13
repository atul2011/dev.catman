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
use ViewModels\Admin\Banner\EditView;
use ViewModels\Admin\Status\CustomErrorView;
use ViewModels\Admin\Status\InternalServerErrorView;
use ViewModels\Status\NotFoundView;

/**
 * Class EditService
 *
 * @package Services\Admin\Banner
 */
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
		$banner = QuarkModel::FindOneById(new Banner(), $request->URI()->Route(3));

		if ($banner == null)
			return QuarkView::InLayout(new NotFoundView(), new QuarkPresenceControl());

		return QuarkView::InLayout(new EditView(), new QuarkPresenceControl(), array('banner' => $banner->Extract()));
	}

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
		$banner->active = $request->active;
		$banner->link = $request->link;

		/**
		 * @var QuarkModel|QuarkFile $file
		 */
		$file = $request->file;

		if ($file->name  != '') {
			$ok = $file->UploadTo(__DIR__ . '/../../../storage/banner/' . Quark::GuID());

			if (!$ok)
				return QuarkView::InLayout(new CustomErrorView(), new QuarkPresenceControl(), array(
					'error_status' => 'Status 500: Internal Server Error',
					'error_message' => 'Cannot store banner!'
				));

			$banner->file = $file;
		}

		if (!$banner->Save())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect('/admin/banner/list');
	}
}
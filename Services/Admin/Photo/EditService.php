<?php
namespace Services\Admin\Photo;

use Models\Photo;
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
use ViewModels\Admin\Photo\IndexView;
use ViewModels\Admin\Status\InternalServerErrorView;
use ViewModels\Admin\Status\NotFoundView;

/**
 * Class EditService
 *
 * @package Services\Admin\Photo
 */
class EditService implements IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication, IQuarkGetService {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new IndexView(), new QuarkPresenceControl(), array('photo'=> QuarkModel::FindOneById(new Photo(), $request->URI()->Route(3))));
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Photo $photo
		 */
		$photo = QuarkModel::FindOneById(new Photo(), $request->URI()->Route(3));

		if ($photo === null)
			return QuarkView::InLayout(new NotFoundView(), new QuarkPresenceControl());

		if (isset($request->photo))
			if ($request->photo->name != '') {
				/**
				 * @var QuarkModel|QuarkFile $file
				 */
				$file = $request->photo;
				$photo->file_name = $request->photo->name;
				$photo->name = Quark::GuID();

				$file->UploadTo(__DIR__ . '/../../../storage/photo/' . $photo->name);

				$photo->file = $file;
			}

		if (!$photo->Save())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect('/admin/photo/list/');
	}
}
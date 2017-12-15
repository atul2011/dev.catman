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
use ViewModels\Admin\Photo\CreateView;
use ViewModels\Admin\Status\ConflictView;
use ViewModels\Admin\Status\InternalServerErrorView;

/**
 * Class CreateService
 *
 * @package Services\Admin\Photo
 */
class CreateService implements IQuarkGetService, IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new CreateView(), new QuarkPresenceControl(), array('photo' => new QuarkModel(new Photo())));
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
		$photo = new QuarkModel(new Photo());

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

		if (!$photo->Create())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect('/admin/photo/list/');
	}
}
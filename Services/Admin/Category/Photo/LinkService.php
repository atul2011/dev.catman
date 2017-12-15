<?php
namespace Services\Admin\Category\Photo;

use Models\Category;
use Models\Category_has_Photo;
use Models\Photo;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class LinkService
 *
 * @package Services\Admin\Category\Photo
 */
class LinkService implements IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication, IQuarkServiceWithCustomProcessor {
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
		 * @var QuarkModel|Category $category
		 */
		$category = QuarkModel::FindOneById(new Category(), $request->URI()->Route(4));

		if ($category == null)
			return array('status' => 400);

		/**
		 * @var QuarkModel|Photo $photo
		 */
		$photo = QuarkModel::FindOneById(new Photo(), $request->photo);

		if ($photo == null) {
			return array(
				'status' => 400,
				'message' => 'Cannot find photo!'
			);
		}

		/**
		 * @var QuarkModel|Category_has_Photo $link
		 */
		$link = Category_has_Photo::GetLink($category, $photo);

		if ($link == null) {
			$link = new QuarkModel(new Category_has_Photo());
			$link->category = $category;
			$link->photo = $photo;

			if (!$link->Create())
				return array(
					'status' => 500,
					'message' => 'Cannot create link'
				);
		}

		return array(
			'status'=> 200,
			'photo' => $photo->Extract(),
			'link' => $link->Extract()
		);
	}
}
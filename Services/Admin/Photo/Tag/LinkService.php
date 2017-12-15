<?php
namespace Services\Admin\Photo\Tag;

use Models\Photo;
use Models\Photo_has_Tag;
use Models\Tag;
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
 * @package Services\Admin\Photo\Tag
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
		 * @var QuarkModel|Photo $photo
		 */
		$photo = QuarkModel::FindOneById(new Photo(), $request->URI()->Route(4));

		if ($photo == null)
			return array('status' => 400);

		/**
		 * @var QuarkModel|Tag $tag
		 */
		$tag = QuarkModel::FindOne(new Tag(), array('name' => $request->tag));

		if ($tag == null) {
			$tag = new QuarkModel(new Tag());
			$tag->name = $request->tag;

			if (!$tag->Create())
				return array(
					'status' => 500,
					'message' => 'Cannot create tag'
				);
		}

		/**
		 * @var QuarkModel|Photo_has_Tag $link
		 */
		$link = Photo_has_Tag::GetLink($photo, $tag);

		if ($link == null) {
			$link = new QuarkModel(new Photo_has_Tag());
			$link->photo = $photo;
			$link->tag = $tag;

			if (!$link->Create())
				return array(
					'status' => 500,
					'message' => 'Cannot create link'
				);
		}

		return array(
			'status' => 200,
			'tag' => $tag->Extract(),
			'link' => $link->Extract()
		);
	}
}
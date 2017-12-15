<?php
namespace Services\Admin\Article\Photo;

use Models\Article;
use Models\Article_has_Photo;
use Models\Photo;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\Quark;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class LinkService
 *
 * @package Services\Admin\Article\Photo
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
		Quark::Trace($request->Data());
		/**
		 * @var QuarkModel|Article $article
		 */
		$article = QuarkModel::FindOneById(new Article(), $request->URI()->Route(4));

		if ($article == null)
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
		 * @var QuarkModel|Article_has_Photo $link
		 */
		$link = Article_has_Photo::GetLink($article, $photo);

		if ($link == null) {
			$link = new QuarkModel(new Article_has_Photo());
			$link->article = $article;
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
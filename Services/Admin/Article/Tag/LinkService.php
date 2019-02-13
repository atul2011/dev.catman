<?php
namespace Services\Admin\Article\Tag;

use Models\Article;
use Models\Article_has_Tag;
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
 * @package Services\Admin\Article\Tag
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
		 * @var QuarkModel|Article $article
		 */
		$article = QuarkModel::FindOneById(new Article(), $request->URI()->Route(4));

		if ($article == null)
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
		 * @var QuarkModel|Article_has_Tag $link
		 */
		$link = Article_has_Tag::GetLink($article, $tag);

		if ($link == null) {
			$link = new QuarkModel(new Article_has_Tag());
			$link->article_id = $article;
			$link->tag_id = $tag;

			if (!$link->Create())
				return array(
					'status' => 500,
					'message' => 'Cannot create link'
				);
		}

		return array(
			'status'=> 200,
			'tag' => $tag->Extract(),
			'link' => $link->Extract()
		);
	}
}
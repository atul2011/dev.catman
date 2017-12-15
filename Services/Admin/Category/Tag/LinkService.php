<?php
namespace Services\Admin\Category\Tag;

use Models\Category;
use Models\Category_has_Tag;
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
 * @package Services\Admin\Category\Tag
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
		 * @var QuarkModel|Category_has_Tag $link
		 */
		$link = Category_has_Tag::GetLink($category, $tag);

		if ($link == null) {
			$link = new QuarkModel(new Category_has_Tag());
			$link->category_id = $category;
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
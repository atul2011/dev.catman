<?php
namespace Services\Admin\Photo;

use Models\Photo;
use Models\Tag;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;
use ViewModels\Admin\Photo\ListView;

/**
 * Class ListService
 *
 * @package Services\Admin\Photo
 */
class ListService implements IQuarkGetService, IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new ListView(), new QuarkPresenceControl(), array('number' => QuarkModel::Count(new Photo())));
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkCollection|Photo $photos
		 */
		$limit = 50;
		$skip = 0;

		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;

		if (isset($request->skip) && ($request->skip !== null))
			$skip = $request->skip;

		$photos = QuarkModel::Find(new Photo(), array(), array(
			QuarkModel::OPTION_LIMIT => $limit,
			QuarkModel::OPTION_SKIP => $skip
		));

		if (isset($request->tag)) {
			/**
			 * @var QuarkModel|Tag $tag
			 */
			$tag = QuarkModel::FindOne(new Tag(), array('name' => $request->tag));

			if ($tag == null)
				return array('status' => 400);

			$photos = $tag->Photos();
		}

		return array(
			'status' => 200,
			'response' => $photos->Extract()
		);
	}
}
<?php
namespace Services\Api\Article;

use Models\Article;
use Models\Photo;
use Quark\IQuarkGetService;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkServiceWithAccessControl;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Api\ApiBehavior;

/**
 * Class IndexService
 *
 * @package Services\Article
 */
class IndexService implements IQuarkGetService, IQuarkServiceWithCustomProcessor, IQuarkServiceWithAccessControl {
	use ApiBehavior;

	/**
	 * @return string
	 */
	public function AllowOrigin () {
		return '*';
	}

	/**
	 * @param QuarkDTO $request
	 *
	 * @return IQuarkIOProcessor
	 */
	public function Processor (QuarkDTO $request) {
		return new QuarkJSONIOProcessor();
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		if (!$this->AuthorizeDevice($request))
			return array('status' => 403);

		/**
		 * @var QuarkModel|Article $article
		 */
		$article = QuarkModel::FindOneById(new Article(), $request->URI()->Route(2));

		if ($article == null)
			return array('status' => 404);

		return array(
			'status' => 200,
			'article' => $article->Extract(),
			'photos' => Photo::PhotosLinks($article->Photos())
		);
	}
}
<?php
namespace Services\Admin\Author;

use Models\Article;
use Models\Author;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class SearchService
 *
 * @package Services\Admin\Author
 */
class SearchService implements IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
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
		 * @var QuarkCollection|Author[] $authors
		 */
		$limit = 50;

		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;

		if ($request->field == 'id' && is_numeric((int)$request->field)) {
			/**
			 * @var QuarkModel|Author $author
			 */
			$author = QuarkModel::FindOneById(new Author(), $request->value);
			$out = array();

			if ($author != null)
				$out[] = $author->Extract(array(
	                  'id',
	                  'name',
	                  'type',
	                  'keywords'
	              ));

			return array(
				'status' => 200,
				'response' => $out
			);
		}
		$authors = QuarkModel::Find(new Author(), array(
			$request->field => array('$regex' => '#.*' . $request->value . '.*#Uisu')
		), array(QuarkModel::OPTION_LIMIT => $limit));


		return array(
			'status' => 200,
			'response' => $authors->Extract(array(
				'id',
				'name',
				'type',
				'keywords'
			))
		);
	}
}
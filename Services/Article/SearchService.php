<?php

namespace Services\Article;

use Models\Article;
<<<<<<< HEAD
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkIOProcessor;
=======
use Models\Articles_has_Categories;
use Models\Author;
use Models\Category;
use Models\Event;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
<<<<<<< HEAD
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Behaviors\AuthorizationBehavior;

class SearchService implements IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
=======
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Behaviors\AuthorizationBehavior;
use Services\Behaviors\CustomProcessorBehavior;

class SearchService implements IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkCollection|Article[] $articles
<<<<<<< HEAD
		 */
		$articles = QuarkModel::Find(new Article());
		$limit = 50;

		$out = $articles->Select(
			array('title' => array('$regex' => '#.*' . $request->title . '.*#Uis')),
			array(QuarkModel::OPTION_LIMIT => $limit)
		);
=======
		 * @var QuarkModel|Event $event
		 * @var QuarkModel|Category $category
		 * @var QuarkModel|Articles_has_Categories $relations
		 * @var QuarkModel|Author $author
		 */
		$limit = 50;
		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;
		$articles = QuarkModel::Find(new Article());
		$out = $articles->Select(
			array($request->Data()->field => array('$regex' => '#.*' . $request->Data()->value . '.*#Uis')),
				array(
				QuarkModel::OPTION_LIMIT => $limit
			)
		);
		$search_value = '';
		$fields = explode('_', $request->Data()->field);
		if (!empty($fields[1])) {
			if ($fields[1] === 'id') {
				if ($fields[0] === 'event') {
					$event = QuarkModel::FindOne(new Event(), array(
						'name' => $request->Data()->value
					));
					$search_value = $event;
				}
				elseif ($fields[0] === 'author') {
					$author = QuarkModel::FindOne(new Author(), array(
						'name' => $request->Data()->value
					));
					$search_value = $author;
				}
				$out = $articles->Select(
					array($request->Data()->field => $search_value),
					array(
						QuarkModel::OPTION_LIMIT => $limit
					)
				);
			}
		}
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4

		return array(
			'status' => 200,
			'response' => $out->Extract(array(
				'id',
				'title',
				'release_date',
				'event_id',
				'txtfield'
			)));
	}
<<<<<<< HEAD

	/**
	 * @param QuarkDTO $request
	 *
	 * @return IQuarkIOProcessor
	 */
	public function Processor (QuarkDTO $request) {
		return new QuarkJSONIOProcessor();
	}
=======
>>>>>>> 870b27ccbd3ae15e497f7464e0a2c2e5474356b4
}
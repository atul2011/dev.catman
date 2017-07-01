<?php

namespace Services\Article;

use Models\Article;
use Models\Articles_has_Categories;
use Models\Author;
use Models\Category;
use Models\Event;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Behaviors\AuthorizationBehavior;
use Services\Behaviors\CustomProcessorBehavior;

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
		 * @var QuarkCollection|Article[] $articles
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
}
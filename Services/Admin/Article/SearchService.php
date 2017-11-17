<?php
namespace Services\Admin\Article;

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
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class SearchService
 *
 * @package Services\Admin\Article
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
		 * @var QuarkCollection|Article[] $articles
		 * @var QuarkModel|Event $event
		 * @var QuarkModel|Category $category
		 * @var QuarkModel|Articles_has_Categories $relations
		 * @var QuarkModel|Author $author
		 */
		$limit = 50;

		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;

		if ($request->field == 'id' && is_numeric((int)$request->field))
			return array(
				'status' => 200,
				'response' => array(QuarkModel::FindOneById(new Article(), $request->value)->Extract(array(
                     'id',
                     'title',
                     'release_date',
                     'event_id'
                 )))
			);

		$articles = QuarkModel::Find(new Article(), array($request->field => array('$regex' => '#.*' . $request->value . '.*#Uisu')), array(
			QuarkModel::OPTION_FIELDS => array(
				'id',
				'title',
				'release_date',
				'event_id'
			),
			QuarkModel::OPTION_LIMIT => $limit
		));

		foreach ($articles as $article)
			$article->RevealAll();

		$search_value = '';
		$fields = explode('_', $request->Data()->field);

		if (!empty($fields[1])) {
			if ($fields[1] === 'id') {
				if ($fields[0] === 'event') {
					$search_value = QuarkModel::FindOne(new Event(), array('name' => $request->value))->id;
				}
				elseif ($fields[0] === 'author') {
					$search_value = QuarkModel::FindOne(new Author(), array('name' => $request->value))->id;
				}

				$articles = $articles->Select(array($request->field => $search_value),
					array(QuarkModel::OPTION_LIMIT => $limit)
				);
			}
		}

		return array(
			'status' => 200,
			'response' => $articles->Extract(array(
				'id',
				'title',
				'release_date',
				'event_id'
			))
		);
	}
}
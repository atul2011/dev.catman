<?php
namespace Services\Api\Category;

use Models\Article;
use Models\Author;
use Models\Category;
use Models\Event;
use Models\Photo;
use Models\Token;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkServiceWithAccessControl;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Api\ApiBehavior;

/**
 * Class IndexService
 *
 * @package Services\Category
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
		 * @var QuarkModel|Category $category
		 */
		$category = QuarkModel::FindOneById(new Category(), $request->URI()->Route(2));

		if ($category == null)
			return array('status' => 404);

		if ($category->sub == Category::TYPE_ARCHIVE) {
			if ($request->URI()->Route(3) == '') {
				return array(
					'status' => 200,
					'sort_fields' => array_keys(Article::ArchiveSortTypes()),
					'category' => $category->Extract()
				);
			}
			else {
				if ($request->URI()->Route(4) == '') {
					$sort_field = $request->URI()->Route(3);

					$out = array();

					if ($sort_field == 'author_id')
						$out = QuarkModel::Find(new Author(), array(), array(
							QuarkModel::OPTION_SORT => array('name' => QuarkModel::SORT_ASC)
						))->Extract(array(
							'id',
							'name'
						));
					elseif ($sort_field == 'event_id')
						$out = QuarkModel::Find(new Event(), array(), array(
							QuarkModel::OPTION_SORT => array('startdate' => QuarkModel::SORT_ASC)
						))->Extract(array(
							'id',
							'name'
						));

					elseif ($sort_field == 'release_date') {
						$year = 2003;

						while ($year <= 2017) {
							$out[] = $year;
							++$year;
						}
					}
					return array(
						'status' => 200,
						'sort_values' => $out,
						'sort_field' => $sort_field,
						'category' => $category->Extract()
					);
				} else {
					/**
					 * @var QuarkCollection|Article[] $articles
					 */
					$query = array();

					if ($request->URI()->Route(3) == 'author_id')
						$query = array('author_id' => $request->URI()->Route(4));
					else if ($request->URI()->Route(3) == 'event_id')
						$query = array('event_id' => $request->URI()->Route(4));
					else if ($request->URI()->Route(3) == 'release_date')
						$query = Article::SearchByYearQuery($request->URI()->Route(4));

					$query[] = array(
						'$or' => array(
							array('type' => Article::TYPE_ARTICLE),
							array('type' => Article::TYPE_MESSAGE),
						),
						'available_on_api' => true
					);

					return array(
						'status' => 200,
						'articles' => QuarkModel::Find(new Article(), $query, array(
							QuarkModel::OPTION_SORT => array('title' => QuarkModel::SORT_ASC),
						))->Extract(array(
                            'id',
                            'title',
                            'runtime_priority'
                        )),
						'category' => $category->Extract(),
						'categories' => $category->ChildCategories(0)->Extract(array(
                            'id',
                            'title',
                            'runtime_priority'
                        )),
						'sort_field' => $request->URI()->Route(3)
					);
				}
			}
		}

		return array(
			'status' => 200,
			'category' => $category->Extract(),
			'articles' => $category->Articles()->Extract(),
			'categories' => $category->ChildCategories(0)->Extract(),
            'photos' => Photo::PhotosLinks($category->Photos())
		);
	}
}
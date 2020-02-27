<?php
namespace Services\Category;

use Models\Article;
use Models\Author;
use Models\Breadcrumb;
use Models\Category;
use Models\Event;
use Models\Link;
use Quark\IQuarkAuthorizableService;
use Quark\IQuarkGetService;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDate;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkSQL;
use Quark\QuarkView;
use Services\ServicesBehavior;
use ViewModels\Category\ArchiveView;
use ViewModels\Category\IndexView;
use ViewModels\LayoutView;
use ViewModels\Status\NotFoundView;

/**
 * Class IndexService
 *
 * @package Services\Category
 */
class IndexService implements IQuarkGetService, IQuarkAuthorizableService {
	use ServicesBehavior;

	/**
	 * @param QuarkDTO $request
	 *
	 * @return string
	 */
	public function AuthorizationProvider (QuarkDTO $request) {
		return CM_SESSION;
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		$session_id = $session->ID() != null ? $session->ID()->Value() : sha1($request->Remote()->host . QuarkDate::GMTNow('d-m-Y'));

		/**
		 * @var QuarkModel|Category $category
		 */
		$category = QuarkModel::FindOneById(new Category(), $request->URI()->Route(1));

		if ($category == null)
			return QuarkView::InLayout(new NotFoundView(),new LayoutView(), array(
				'model'=> 'Category',
				'title' => 'Status: 404'
			));

		if ($category->available_on_site != true)
			return QuarkView::InLayout(new NotFoundView(),new LayoutView(), array(
				'model'=> 'Category',
				'title' => 'Status: 404'
			));

		if ($category->sub == Category::TYPE_ARCHIVE) {
			if ($request->URI()->Route(2) != 'sort') {
				return QuarkView::InLayout(new ArchiveView(), new LayoutView(), array(
					'sort_fields' => Article::ArchiveSortTypes(),
					'title' => $category->title,
					'category' => $category
				));
			}
			else {
				if (strlen($request->URI()->Route(4)) == 0) {
					$sort_field = $request->URI()->Route(3);

					$out = array();

					if ($sort_field == Category::ARCHIVE_SORT_AUTHOR) {
						$out = QuarkModel::Find(new Author(), array(
							'type' => array(
								'$ne' => Author::TYPE_HUMAN
							)
						), array(
							QuarkModel::OPTION_SORT => array('name' => QuarkModel::SORT_ASC)
						));
					}
					elseif ($sort_field == Category::ARCHIVE_SORT_EVENT) {
						$out = QuarkModel::Find(new Event(), array(
							'startdate' => array(
								'$ne' => '0000-00-00'
							)
						), array(
							QuarkModel::OPTION_SORT => array('startdate' => QuarkModel::SORT_ASC)
						));
					}
					elseif ($sort_field == Category::ARCHIVE_SORT_DATE) {
						for ($year = 2003; $year <= (int)date('Y'); $year++) {
							$out[] = $year;
						}
					}

					return QuarkView::InLayout(new ArchiveView(), new LayoutView(), array(
						'sort_values' => $out,
						'sort_field' => $sort_field,
						'sort_fields' => Article::ArchiveSortTypes(),
						'title' => $category->title,
						'category' => $category
					));
				}
				else {
					/**
					 * @var QuarkCollection|Article[] $articles
					 */
					$query = array();
					$sort_field_title = '';

					if ($request->URI()->Route(3) == Category::ARCHIVE_SORT_AUTHOR) {
						/**
						 * @var QuarkModel|Author $author
						 */
						$author = QuarkModel::FindOneById(new Author(), $request->URI()->Route(4));

						if ($author != null)
							$sort_field_title = $author->name;

						$query = array('author_id.value' => $request->URI()->Route(4));
					}
					else if ($request->URI()->Route(3) == Category::ARCHIVE_SORT_EVENT) {
						/**
						 * @var QuarkModel|Event $event
						 */
						$event = QuarkModel::FindOneById(new Event(), $request->URI()->Route(4));

						if ($event != null)
							$sort_field_title = $event->name;

						$query = array('event_id.value' => $request->URI()->Route(4));
					}
					else if ($request->URI()->Route(3) == Category::ARCHIVE_SORT_DATE) {
						$sort_field_title = $request->URI()->Route(4);
						$query = Article::SearchByYearQuery($request->URI()->Route(4));
					}

					return QuarkView::InLayout(new ArchiveView(), new LayoutView(), array(
						'articles' => QuarkModel::Find(new Article(), array(
							'$or' => array(
								array('type' => Article::TYPE_ARTICLE),
								array('type' => Article::TYPE_MESSAGE)
							),
							'available_on_site' => true
						), array(
							QuarkModel::OPTION_FIELDS => array(
								'id',
								'title',
								'release_date',
								'publish_date',
								'copyright',
								'priority',
								'type',
								'event_id',
								'author_id',
								'short_title',
								'resume'
							)
						))->Select($query, array(
							QuarkModel::OPTION_SORT => array(
								'release_date' => QuarkModel::SORT_ASC,
								'title' => QuarkModel::SORT_ASC
							),
							QuarkSQL::OPTION_QUERY_REVIEWER => function ($query) {
								return $query . 'GROUP BY `title`';
							}
						)),
						'title' => $category->title,
						'category' => $category,
						'sort_fields' => Article::ArchiveSortTypes(),
						'sort_field' => $request->URI()->Route(3),
						'sort_field_title' => $sort_field_title
					));
				}
			}
		}

		if ($category->sub == Category::TYPE_QNA) {
			if (strlen($request->URI()->Route(4)) != 0) {
				$sort_field_title = '';

				/**
				 * @var QuarkModel|Event $event
				 */
				$event = QuarkModel::FindOneById(new Event(), $request->URI()->Route(4));

				if ($event != null)
					$sort_field_title = $event->name;

				return QuarkView::InLayout(new ArchiveView(), new LayoutView(), array(
					'articles' => QuarkModel::Find(new Article(), array(
						'type' => Article::TYPE_QUESTION,
						'available_on_site' => true
					), array(
						QuarkModel::OPTION_FIELDS => array(
							'id',
							'title',
							'release_date',
							'publish_date',
							'copyright',
							'priority',
							'type',
							'event_id',
							'author_id',
							'short_title',
							'resume'
						)
					))->Select(array('event_id.value' => $event->id), array(
						QuarkModel::OPTION_SORT => array(
							'release_date' => QuarkModel::SORT_ASC,
							'title' => QuarkModel::SORT_ASC
						),
						QuarkSQL::OPTION_QUERY_REVIEWER => function ($query) {
							return $query . 'GROUP BY `title`';
						}
					)),
					'title' => $category->title,
					'category' => $category,
					'sort_field' => $request->URI()->Route(3),
					'sort_field_title' => $sort_field_title
				));
			}

			return QuarkView::InLayout(new ArchiveView(), new LayoutView(), array(
				'sort_values' => Event::QuestionEvents(),
				'sort_field' => 'event_id',
				'title' => $category->title,
				'category' => $category
			));
		}

		$content = str_replace('<p><br></p>', ' ', $category->intro);

		if (strlen($content) > 0)
			$category->intro = $content;

		if (!$category->Save())
			Quark::Log('Cannot save category ' . $category->id, Quark::LOG_FATAL);

		//Set breadcrumb---------------------
		if ($category->master)
			Breadcrumb::Set($session_id, $category->id);

		$this->SetUserBreadcrumb($session_id, $category);

		return QuarkView::InLayout(new IndexView(), new LayoutView(), array(
			'category' => $category,
			'title' => $category->title,
		    'user' => $session_id,
		    'links' => QuarkModel::Find(new Link(), array(
			    'target_type' => Link::TARGET_TYPE_CATEGORY,
			    'target_value' => (int)$category->id
		    ), array(
		    	QuarkModel::OPTION_SORT => array(
		    		'priority' => QuarkModel::SORT_ASC,
			        'title' => QuarkModel::SORT_ASC
			    )
		    ))
		));
	}
}
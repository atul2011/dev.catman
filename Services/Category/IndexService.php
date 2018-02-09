<?php
namespace Services\Category;

use Models\Article;
use Models\Author;
use Models\Category;
use Models\Event;
use Quark\IQuarkGetService;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use ViewModels\Category\ArchiveView;
use ViewModels\Category\IndexView;
use ViewModels\LayoutView;
use ViewModels\Status\NotFoundView;

/**
 * Class IndexService
 *
 * @package Services\Category
 */
class IndexService implements IQuarkGetService{
	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
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
				if ($request->URI()->Route(4) == '') {
					$sort_field = $request->URI()->Route(3);

					$out = array();

					if ($sort_field == 'author_id')
						$out = QuarkModel::Find(new Author(), array(), array(
							QuarkModel::OPTION_SORT => array('name' => QuarkModel::SORT_ASC)
						));
					elseif ($sort_field == 'event_id')
						$out = QuarkModel::Find(new Event(), array(), array(
							QuarkModel::OPTION_SORT => array('startdate' => QuarkModel::SORT_ASC)
						));
					elseif ($sort_field == 'release_date') {
						$year = 2003;
						while ($year <= 2017) {
							$out[] = $year;
							++$year;
						}
					}
					return QuarkView::InLayout(new ArchiveView(), new LayoutView(), array(
						'sort_values' => $out,
						'sort_field' => $sort_field,
						'title' => $category->title,
						'category' => $category
					));
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
						'available_on_site' => true
					);

					return QuarkView::InLayout(new ArchiveView(), new LayoutView(), array(
						'articles' => QuarkModel::Find(new Article(), $query, array(
							QuarkModel::OPTION_SORT => array('title' => QuarkModel::SORT_ASC),
						))->Extract(),
						'title' => $category->title,
						'category' => $category,
						'sort_field' => $request->URI()->Route(3)
					));
				}
			}
		}

		return QuarkView::InLayout(new IndexView(), new LayoutView(), array(
			'category' => $category,
			'title' => $category->title
		));
	}
}
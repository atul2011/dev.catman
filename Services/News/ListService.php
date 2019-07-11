<?php
namespace Services\News;

use Models\News;
use Quark\IQuarkGetService;
use Quark\QuarkDate;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\QuarkViewBehavior;
use ViewModels\LayoutView;
use ViewModels\News\ListView;

/**
 * Class ListService
 *
 * @package Services\News
 */
class ListService implements IQuarkGetService  {
	use QuarkViewBehavior;
	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new ListView(),new LayoutView(), array(
			'news' => QuarkModel::Find(new News(), array(), array(
				QuarkModel::OPTION_SORT => array('publish_date' => QuarkModel::SORT_DESC),
			)),
			'title' => $this->CurrentLocalizationOf('Catman.Localization.News.Label.Many')
		));
	}
}
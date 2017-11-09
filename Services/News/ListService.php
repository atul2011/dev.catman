<?php
namespace Services\News;

use Models\News;
use Quark\IQuarkGetService;
use Quark\QuarkDate;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use ViewModels\LayoutView;
use ViewModels\News\ListView;

/**
 * Class ListService
 *
 * @package Services\News
 */
class ListService implements IQuarkGetService  {
	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new ListView(),new LayoutView(),array(
			'news' => QuarkModel::Find(new News(), array(
					'publish_date' => array('$lte' => QuarkDate::GMTNow()->Format('Y-m-d'))
				)
			)
		));
	}
}
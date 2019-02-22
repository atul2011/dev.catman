<?php
namespace Services;

use Models\Term;
use Quark\IQuarkGetService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use ViewModels\GlossaryView;
use ViewModels\LayoutView;

/**
 * Class GlossaryService
 *
 * @package Services
 */
class GlossaryService implements IQuarkGetService {
	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		$letters = Term::Letters();
		$listed_letters = $letters;
		$criteria = array();

		if (strlen($request->URI()->Route(1)) > 0) {
			if (in_array($request->URI()->Route(1), $letters)) {
				$listed_letters = array($request->URI()->Route(1));
				$criteria = array('first_letter' => $request->URI()->Route(1));
			}
		}

		return QuarkView::InLayout(new GlossaryView(), new LayoutView(), array(
			'letters' => $letters,
			'listed_letters' => $listed_letters,
		    'terms' => QuarkModel::Find(new Term(), $criteria, array(
			    QuarkModel::OPTION_SORT => array('title' => QuarkModel::SORT_ASC)
		    )),
		    'title' => 'Глоссарий'
		));
	}
}
<?php
namespace Services\Api\Term;

use Models\Term;
use Quark\IQuarkGetService;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkServiceWithAccessControl;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\Quark;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Api\ApiBehavior;

/**
 * Class ListService
 *
 * @package Services\Api\Term
 */
class ListService implements IQuarkGetService, IQuarkServiceWithCustomProcessor, IQuarkServiceWithAccessControl {
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

		$letters = Term::Letters();
		$listed_letters = $letters;
		$criteria = array();
		$letter = $request->URI()->Route(3);

		if (strlen($letter ) > 0) {
			if (in_array($letter , $letters)) {
				$listed_letters = array($letter);
				$criteria = array('first_letter' => $letter);
			}
		}

		return array(
			'status' => 200,
			'letters' => $letters,
			'listed_letters' => $listed_letters,
			'terms' => QuarkModel::Find(new Term(), $criteria, array(
				QuarkModel::OPTION_SORT => array('title' => QuarkModel::SORT_ASC)
			))->Extract(),
			'title' => 'Глоссарий'
		);
	}

}
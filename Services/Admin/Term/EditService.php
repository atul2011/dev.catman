<?php
namespace Services\Admin\Term;

use Models\Term;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\Term\IndexView;
use ViewModels\Admin\Status\InternalServerErrorView;
use ViewModels\Admin\Status\NotFoundView;

/**
 * Class EditService
 *
 * @package Services\Admin\Term
 */
class EditService implements IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication, IQuarkGetService {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new IndexView(), new QuarkPresenceControl(), array('term'=> QuarkModel::FindOneById(new Term(), $request->URI()->Route(3))));
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Term $term
		 */
		$term = QuarkModel::FindOneById(new Term(), $request->URI()->Route(3));

		if($term === null)
			return QuarkView::InLayout(new NotFoundView(), new QuarkPresenceControl());

		$term->PopulateWith(array(
			'title' => htmlspecialchars(trim($request->title)),
			'description' => htmlspecialchars(trim($request->description))
		));

		if (!$term->Save())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect('/admin/term/list/');
	}
}
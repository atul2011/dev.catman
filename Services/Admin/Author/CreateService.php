<?php

namespace Services\Admin\Author;

use Models\Author;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\Content\Author\CreateView;

class CreateService implements IQuarkGetService, IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		return QuarkView::InLayout(new CreateView(), new QuarkPresenceControl());
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Author $author
		 */
		$author = QuarkModel::FindOne(new Author(), array(
			'name' => $request->Data()->name
		));
		if ($author !== null)
			return QuarkDTO::ForRedirect('/admin/author/edit?create=none');

		$author = new QuarkModel(new Author(), $request->Data());

		if (!$author->Create())
			return QuarkDTO::ForRedirect('/admin/author/edit?create=false');

		return QuarkDTO::ForRedirect('/admin/author/list?create=true');
	}
}
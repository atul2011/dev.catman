<?php

namespace Services\Admin\Author;

use Models\Author;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;

class DeleteService implements IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

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
		$id = $request->URI()->Route(3);
		$author = QuarkModel::FindOneById(new Author(), $id);
		if (!$author->Remove())
			QuarkDTO::ForRedirect('/admin/author/list?deleted=false&id=' . $id);

		QuarkDTO::ForRedirect('/admin/author/list?deleted=true&id=' . $id);
	}
}
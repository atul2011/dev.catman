<?php
namespace Services\Admin\User;

use Models\News;
use Models\User;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkCollection;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Services\Admin\Behaviors\AuthorizationBehavior;
use Services\Admin\Behaviors\CustomProcessorBehavior;

/**
 * Class SearchService
 *
 * @package Services\Admin\User
 */
class SearchService implements IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;
	use CustomProcessorBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkCollection|User[] $users
		 */
		$limit = 50;

		if (isset($request->limit) && ($request->limit !== null))
			$limit = $request->limit;

		if ($request->field == 'id'  && is_numeric($request->field)) {
			/**
			 * @var QuarkModel|User $user
			 */
			$user = QuarkModel::FindOneById(new User(), $request->value);
			$out = array();

			if ($user != null)
				$out[] = $user->Extract(array(
	                    'id',
	                    'login',
	                    'name',
	                    'email',
	                    'rights'
                ));

			return array(
				'status' => 200,
				'response' => $out
			);
		}

		$users = QuarkModel::Find(new User(), array(
				$request->field => array('$regex' => '#.*' . $request->value . '.*#Uisu')),
			array(QuarkModel::OPTION_LIMIT => $limit)
		);

		return array(
			'status' => 200,
			'response' => $users->Extract(array('id', 'login', 'name', 'email', 'rights'))
		);
	}
}
<?php
namespace Services\Admin\Token;

use Models\Token;
use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;
use Quark\ViewResources\Quark\QuarkPresenceControl\QuarkPresenceControl;
use Services\Admin\Behaviors\AuthorizationBehavior;
use ViewModels\Admin\Status\ConflictView;
use ViewModels\Admin\Status\InternalServerErrorView;

/**
 * Class CreateService
 *
 * @package Services\Admin\Token
 */
class CreateService implements IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
	use AuthorizationBehavior;

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		$token_string = Token::GenerateToken();

		/**
		 * @var QuarkModel|Token $token
		 */
		$token = QuarkModel::FindOne(new Token(), array('token' => $token));

		if ($token != null)
			return QuarkView::InLayout(new ConflictView(), new QuarkPresenceControl());

		$token = new QuarkModel(new Token(), array('token' => $token_string));

		if (!$token->Create())
			return QuarkView::InLayout(new InternalServerErrorView(), new QuarkPresenceControl());

		return QuarkDTO::ForRedirect('/admin/token/list');
	}
}
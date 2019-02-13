<?php
namespace Services\Api;

use Models\Token;
use Quark\QuarkDTO;
use Quark\QuarkModel;

/**
 * Class ApiBehavior
 *
 * @package Services\Api
 */
trait ApiBehavior {
	/**
	 * @param QuarkDTO $request
	 *
	 * @return bool
	 */
	public function AuthorizeDevice (QuarkDTO $request) {
		return QuarkModel::FindOne(new Token(), array('token' => $request->token)) != null;
	}
}
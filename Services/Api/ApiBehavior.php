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
		$token = isset($request->token) ? $request->token : '';

		if (strlen($request->URI()->query) == 0) {
			$step1 = explode('%3F', $request->URI()->path)[1];
			$step2 = explode('&', $step1)[0];
			$token = explode('=', $step2)[1];
		}

		return QuarkModel::FindOne(new Token(), array('token' => $token)) != null;
	}
}
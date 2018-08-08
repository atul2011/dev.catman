<?php
namespace Services\Api;

use Models\Token;
use Models\UserDevice;
use Quark\Extensions\PushNotification\Device;
use Quark\IQuarkIOProcessor;
use Quark\IQuarkPostService;
use Quark\IQuarkServiceWithAccessControl;
use Quark\IQuarkServiceWithCustomProcessor;
use Quark\QuarkDTO;
use Quark\QuarkJSONIOProcessor;
use Quark\QuarkModel;
use Quark\QuarkSession;

/**
 * Class AuthorizeService
 *
 * @package Services\Api
 */
class AuthorizeService implements IQuarkPostService, IQuarkServiceWithCustomProcessor, IQuarkServiceWithAccessControl {
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
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|Device $device
		 */
		$device = $request->device;

		if (strlen($device->id) == 0 || strlen($device->type) == 0)
			return array('status' => 400);

		/**
		 * @var QuarkModel|UserDevice $user_device
		 *
		 */
		$user_device = QuarkModel::FindOne(new UserDevice(), array(
			'device_id' => trim($device->id),
			'device_type' => trim($device->type)
		));

		if ($user_device == null) {
			$user_device = new QuarkModel(new UserDevice());
			$user_device->device_id = trim($device->id);
			$user_device->device_type = trim($device->type);

			if (!$user_device->Create())
				return array('status' => 500);
		}

		/**
		 * @var QuarkModel|Token $token
		 */
		$token = QuarkModel::FindOne(new Token(), array(), array(
			QuarkModel::OPTION_SORT => array('created' => QuarkModel::SORT_DESC)
		));

		return array(
			'status' => 200,
			'token' => $token->token
		);
	}
}
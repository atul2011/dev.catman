<?php
namespace Services\PushNotification;

use Models\Notification;
use Models\UserDevice;
use Quark\Extensions\PushNotification\Device;
use Quark\Extensions\PushNotification\Providers\GoogleFCM\GoogleFCMDetails;
use Quark\Extensions\PushNotification\PushNotification;
use Quark\IQuarkScheduledTask;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDate;
use Quark\QuarkModel;

/**
 * Class SendService
 *
 * @package Services\PushNotification
 */
class SendService implements IQuarkScheduledTask {
	/**
	 * @param QuarkDate $previous
	 *
	 * @return bool
	 */
	public function LaunchCriteria (QuarkDate $previous) {
		return $previous->Earlier(QuarkDate::Now()->Offset('-60 seconds'));
	}

	/**
	 * @param int $argc
	 * @param array $argv
	 *
	 * @return mixed
	 */
	public function Task ($argc, $argv) {
		/**
		 * @var QuarkCollection|Notification[] $notifications
		 * @var QuarkCollection|UserDevice[] $devices
		 */
		$notifications = QuarkModel::Find(new Notification(), array('sent' => false));
		$devices = QuarkModel::Find(new UserDevice());

		foreach ($notifications as $notification) {

			foreach ($devices as $item) {
				$push = new PushNotification(CM_PUSH_NOTIFICATION);
				/**
				 * @var QuarkModel|Device $device
				 */
				$device = new QuarkModel(new Device());
				$device->id = $item->device_id;
				$device->type = $item->device_type;
				$device->date = $item->date;

				$push->Device($device->Model());
				$push->Details(new GoogleFCMDetails('UniversalPath', $notification->content));
				$push->Payload(array(
					'type' => $notification->type,
					'target' => $notification->target
				));

				if (!$push->Send())
					Quark::Log('Cannot send push notification:' . $notification->id);

				$notification->sent = true;

				if (!$notification->Save())
					Quark::Log('Cannot send push for notification:' . (string)$notification->id);

				unset($device);
				unset($push);
			}
			unset($notification);
			unset($devices);
		}

		unset($notifications);
	}
}
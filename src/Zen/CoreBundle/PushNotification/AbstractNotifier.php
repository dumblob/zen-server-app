<?php
namespace Zen\CoreBundle\PushNotification;

use RMS\PushNotificationsBundle\Service\Notifications;

abstract class AbstractNotifier
{
    /**
     * @var Notifications
     */
    protected $notifications;

    /**
     * Sends push notification to specified device.
     *
     * @param string $device_id
     * @param mixed $data
     */
    public abstract function send($device_id, $data);

    public function setNotifications(Notifications $notifications)
    {
        $this->notifications = $notifications;
    }
}

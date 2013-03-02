<?php
namespace Zen\CoreBundle\PushNotification;

use RMS\PushNotificationsBundle\Message\AndroidMessage;

class AndroidNotifier extends AbstractNotifier
{
    public function send($device_id, $data)
    {
        $message = new AndroidMessage();
        $message->setDeviceIdentifier($device_id);
        $message->setGCM(true);
        $message->setData($data);

        $this->notifications->send($message);
    }
}

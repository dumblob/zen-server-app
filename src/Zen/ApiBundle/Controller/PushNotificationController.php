<?php
namespace Zen\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Zen\CoreBundle\Document\PushNotification;

class PushNotificationController extends Controller
{
    public function registerAction($device_id)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $notification = $dm->getRepository('ZenCoreBundle:PushNotification')->findOneByDeviceId($device_id);

        $created = false;
        if ($notification === null) {
            $created = true;
            $notification = new PushNotification();
            $notification->setDeviceId($device_id);
        }

        $data = json_decode(urldecode($this->getRequest()->getContent()));

        $notification->setRegistrationId($data->registration_id);

        $dm->persist($notification);
        $dm->flush();

        return new Response(null, $created ? 201 : 200);
    }

    public function unregisterAction($device_id)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();

        $notification = $dm->getRepository('ZenCoreBundle:PushNotification')->findOneByDeviceId($device_id);
        if ($notification === null) {
            $message = $this->get('translator')->trans(
                'error.device_id_not_found',
                ['device_id' => $device_id],
                'ZenApiBundle'
            );

            return new Response(json_encode(['message' => $message]), 404);
        }

        $dm->remove($notification);
        $dm->flush();

        return new Response(null, 200);
    }
}

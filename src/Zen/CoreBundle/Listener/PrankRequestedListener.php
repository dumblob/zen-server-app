<?php
namespace Zen\CoreBundle\Listener;

use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zen\CoreBundle\Event\PrankRequestedEvent;
use Zen\CoreBundle\PushNotification\AbstractNotifier;

class PrankRequestedListener
{
    /**
     * @var AbstractNotifier
     */
    private $notifier;

    /**
     * @var ManagerRegistry
     */
    private $doctrineMongo;

    public function setNotifier(AbstractNotifier $notifier)
    {
        $this->notifier = $notifier;
    }

    public function setDoctrineMongo(ManagerRegistry $doctrineMongo)
    {
        $this->doctrineMongo = $doctrineMongo;
    }

    public function onPrankRequested(PrankRequestedEvent $event)
    {
        $notification = $this->doctrineMongo
            ->getRepository('ZenCoreBundle:PushNotification')
            ->findOneByDeviceId($event->getTargetId())
        ;
        if ($notification === null) {
            throw new NotFoundHttpException("Device ID not found");
        }

        $content = [
            'type' => $event->getType(),
            'data' => json_decode($event->getData()),
        ];

        $this->notifier->send($notification->getRegistrationId(), json_encode($content));
    }
}

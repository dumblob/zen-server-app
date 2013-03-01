<?php
namespace Zen\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\HttpFoundation\Response;
use Zen\CoreBundle\Document\DeviceLocation;
use Zen\CoreBundle\Event\PrankRequestedEvent;

class DeviceController extends Controller
{
    public function locationAction($device_id)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();

        $location = $dm->getRepository('ZenCoreBundle:DeviceLocation')->findOneByDeviceId($device_id);

        $created = false;
        if ($location === null) {
            $created = true;
            $location = new DeviceLocation();
            $location->setDeviceId($device_id);
        }

        $data = json_decode(urldecode($this->getRequest()->getContent()));

        $location->setLatitude($data->location->lat);
        $location->setLongitude($data->location->lng);
        $location->setTime(new \DateTime());

        $dm->persist($location);
        $dm->flush();

        $result = [
            'device_id' => $location->getDeviceId(),
            'location' => ['lat' => (float) $location->getLatitude(),
            'lng' => (float) $location->getLongitude()],
            'timestamp' => (int) $location->getTime()->format('U')
        ];

        return new Response(json_encode($result), $created ? 201 : 200);
    }

    public function deleteAction($device_id)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();

        $location = $dm->getRepository('ZenCoreBundle:DeviceLocation')->findOneByDeviceId($device_id);
        if ($location === null) {
            $message = $this->get('translator')->trans(
                'error.device_id_not_found',
                ['device_id' => $device_id],
                'ZenApiBundle'
            );

            return new Response(json_encode(['message' => $message]), 404);
        }

        $dm->remove($location);
        $dm->flush();

        return new Response(null, 200);
    }

    public function prankAction($device_id)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $repo = $dm->getRepository('ZenCoreBundle:DeviceLocation');

        $location = $repo->findOneByDeviceId($device_id);
        if ($location === null) {
            $message = $this->get('translator')->trans(
                'error.device_id_not_found',
                ['device_id' => $device_id],
                'ZenApiBundle'
            );

            return new Response(json_encode(['message' => $message]), 404);
        }

        $data = json_decode(urldecode($this->getRequest()->getContent()));

        $distance = $dm->getRepository('ZenCoreBundle:Distance')->findOneByName($data->distance);
        if ($distance === null) {
            $message = $this->get('translator')->trans(
                'error.distance_not_valid',
                ['distance' => $data->distance],
                'ZenApiBundle'
            );

            return new Response(json_encode(['message' => $message]), 404);
        }
        $distance = $distance->getRange();

        $qb = $repo->createQueryBuilder()
            ->field('deviceId')->notEqual($location->getDeviceId())
            ->field('latitude')->range($location->getLatitude() - $distance, $location->getLatitude() + $distance)
            ->field('longitude')->range($location->getLongitude() - $distance, $location->getLongitude() + $distance)
        ;
        $locations = $qb->getQuery()->execute()->toArray();
        if (count($locations) === 0) {
            $message = $this->get('translator')->trans('error.no_result', ['device_id' => $device_id], 'ZenApiBundle');

            return new Response(json_encode(['message' => $message]), 404);
        }

        $ids = array_keys($locations);
        $target = $locations[$ids[rand(0, count($locations) - 1)]];

        $event = new PrankRequestedEvent($target->getDeviceId(), $data->type, $data->data);
        $this->get('event_dispatcher')->dispatch(PrankRequestedEvent::EVENT_NAME, $event);

        return new Response(null, 200);
    }
}

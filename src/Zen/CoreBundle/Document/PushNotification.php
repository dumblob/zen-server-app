<?php
namespace Zen\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class PushNotification
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     * @MongoDB\Index(unique=true)
     */
    protected $deviceId;

    /**
     * @MongoDB\String
     * @MongoDB\Index(unique=true)
     */
    protected $registrationId;

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set deviceId
     *
     * @param string $deviceId
     * @return DeviceLocation
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    /**
     * Get deviceId
     *
     * @return string $deviceId
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * Set registrationId
     *
     * @param string registrationId
     * @return PushNotification
     */
    public function setRegistrationId($registrationId)
    {
        $this->registrationId = $registrationId;

        return $this;
    }

    /**
     * Get registrationId
     *
     * @return string $registrationId
     */
    public function getRegistrationId()
    {
        return $this->registrationId;
    }
}

<?php
namespace Zen\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class DeviceLocation
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
     * @MongoDB\Float
     */
    protected $latitude;

    /**
     * @MongoDB\Float
     */
    protected $longitude;

    /**
     * @MongoDB\Date
     */
    protected $time;

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
     * Set latitude
     *
     * @param float $latitude
     * @return DeviceLocation
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float $latitude
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return DeviceLocation
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float $longitude
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set time
     *
     * @param float $time
     * @return DeviceLocation
     */
    public function setTime(\DateTime $time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }
}

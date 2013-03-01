<?php
namespace Zen\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Distance
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     * @MongoDB\Index(unique=true)
     */
    protected $name;

    /**
     * @MongoDB\Float
     */
    protected $range;

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
     * Set name
     *
     * @param string $name
     * @return Distance
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set range
     *
     * @param float $range
     * @return Distance
     */
    public function setRange($range)
    {
        $this->range = abs($range);
        return $this;
    }

    /**
     * Get range
     *
     * @return float $range
     */
    public function getRange()
    {
        return $this->range;
    }
}

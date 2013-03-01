<?php
namespace Zen\CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class PrankRequestedEvent extends Event
{
    /**
     * @var string
     */
    const EVENT_NAME = 'prank.requested';

    /**
     * @var string
     */
    private $targetId;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $data;

    /**
     * @param string $targetId
     * @param string $type
     * @param string $data
     */
    public function __construct($targetId, $type, $data)
    {
        $this->targetId = $targetId;
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getTargetId()
    {
        return $this->targetId;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }
}

<?php

namespace Obos\Bundle\CoreBundle\Entity\Template;

use Doctrine\ORM\Mapping as ORM,
    InvalidArgumentException;

/**
 * Implements status dependency in an entity.
 *
 * This class can be extended as is, or you can override the built-in constants (as well as
 * add your own), and override the {@see getStatusOptions()} method to reflect your
 * options.
 *
 */
abstract class StatusedEntity
{
    // Status options
    const STATUS_CANCELLED = -1;
    const STATUS_NEW       = 0;
    const STATUS_INACTIVE  = 1;
    const STATUS_ACTIVE    = 2;
    const STATUS_COMPLETE  = 3;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  int  The entity's status.
     *
     * @ORM\Column(type="smallint", nullable=FALSE)
     */
    protected $status = self::STATUS_NEW;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Get a list of the available options for {@see $status}.
     *
     * @return  int[]
     */
    public function getStatusOptions()
    {
        return [
            self::STATUS_CANCELLED,
            self::STATUS_NEW,
            self::STATUS_INACTIVE,
            self::STATUS_ACTIVE,
            self::STATUS_COMPLETE
        ];
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Set the entity's status.
     *
     * @param   int  $status
     * @return  $this
     *
     * @throws  InvalidArgumentException  if the status supplied isn't in the defined list.
     */
    public function setStatus($status)
    {
        if (!in_array($status, $this->getStatusOptions()))
        {
            throw new InvalidArgumentException('Invalid status given.');
        }

        $this->status = $status;

        return $this;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Get the entity's status.
     *
     * @return  int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Check the entity's status against an expected value.
     *
     * @param   int  $queriedStatus
     * @return  bool
     *
     * @throws  InvalidArgumentException  if the status supplied isn't in the defined list.
     */
    public function statusIs($queriedStatus)
    {
        if (!in_array($queriedStatus, $this->getStatusOptions()))
        {
            throw new InvalidArgumentException('Invalid status for query.');
        }

        return ($this->status == $queriedStatus);
    }
}

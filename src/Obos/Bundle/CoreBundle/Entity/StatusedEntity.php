<?php

namespace Obos\Bundle\CoreBundle\Entity;


/**
 * Defines the common API to "statused" entities. Implemented as an abstract class because
 * PHP traits do not yet support the definition of constants.
 *
 * To implement additional statuses, simply override the existing constant values and/or
 * append your new status constants, then override the {@see getValidStatuses()} method to
 * reflect your changes.
 *
 */
abstract class StatusedEntity {

    const STATUS_CANCELLED = 0;
    const STATUS_INACTIVE  = 1;
    const STATUS_ACTIVE    = 2;
    const STATUS_COMPLETE  = 3;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  int
     */
    protected $status = self::STATUS_ACTIVE;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Get a list of acceptable statuses for setting and checking the {@see $status} property
     *
     * @return  int[]  An array of valid statuses.
     */
    protected function getValidStatuses()
    {
        return [
            self::STATUS_CANCELLED,
            self::STATUS_INACTIVE,
            self::STATUS_ACTIVE,
            self::STATUS_COMPLETE
        ];
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param   int  $status
     * @return  $this
     *
     * @throws  \InvalidArgumentException  if $status does not match one of the defined STATUS_
     *                                     constant values.
     */
    final public function setStatus($status)
    {
        if (!in_array($status, $this->getValidStatuses()))
        {
            throw new \InvalidArgumentException('Invalid status given.');
        }

        $this->status = $status;

        return $this;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @return  int
     */
    final public function getStatus()
    {
        return $this->status;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Check whether the project has a given status.
     *
     * @param   int  $status  One of the STATUS_ constants defined in this class.
     * @return  bool          Whether the project's status matches the queried status.
     *
     * @throws  \InvalidArgumentException  if $status is not one of the defined STATUS_
     *                                     constants.
     */
    final public function statusIs($status)
    {
        if (!in_array($status, $this->getValidStatuses()))
        {
            throw new \InvalidArgumentException('Invalid status query.');
        }

        return $this->status == $status;
    }
}

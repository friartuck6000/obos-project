<?php

namespace Obos\Bundle\CoreBundle\Entity;

use DateTime;


/**
 * Defines the common API to entities that have a due date
 *
 */
trait DeliverableTrait {

    /**
     * @param   DateTime  $dateDue
     * @return  $this
     */
    public function setDateDue(DateTime $dateDue)
    {
        $this->dateDue = $dateDue;
        return $this;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @return  DateTime
     */
    public function getDateDue()
    {
        return $this->dateDue;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Check to see if the due date has passed. If the due date isn't set, this method will
     * always return FALSE.
     *
     * @return  bool
     */
    public function isOverdue()
    {
        if (!$this->dateDue)
        {
            return FALSE;
        }

        $now = new DateTime();

        return $now > $this->dateDue;
    }
}
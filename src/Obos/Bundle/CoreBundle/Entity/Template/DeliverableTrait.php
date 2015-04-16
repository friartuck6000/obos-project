<?php

namespace Obos\Bundle\CoreBundle\Entity\Template;

use Doctrine\ORM\Mapping as ORM,
    DateTime;


/**
 * Implements the dateDue timestamp for entities with a due/deliverable date.
 *
 */
trait DeliverableTrait
{
    /**
     * @var  DateTime  The due/deliverable timestamp.
     *
     * @ORM\Column(type="datetime", nullable=TRUE)
     */
    protected $dateDue;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Set the dateDue timestamp.
     *
     * @param   DateTime  $due
     * @return  $this
     */
    public function setDateDue(DateTime $due = NULL)
    {
        $this->dateDue = $due;

        return $this;
    }

    /**
     * Semantic alias for {@see setDateDue()}.
     *
     * @param   DateTime  $due
     * @return  $this
     */
    public function setDueDate(DateTime $due = NULL)
    {
        $this->setDateDue($due);

        return $this;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Get the dateDue timestamp.
     *
     * @return  DateTime
     */
    public function getDateDue()
    {
        return $this->dateDue;
    }

    /**
     * Semantic alias for {@see getDateDue()}.
     *
     * @return  DateTime
     */
    public function getDueDate()
    {
        return $this->getDateDue();
    }

    /**
     * Check to see if the dateDue has passed.
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

        return ($now > $this->dateDue);
    }
}

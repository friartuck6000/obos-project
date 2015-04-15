<?php

namespace Obos\Bundle\CoreBundle\Entity;

use DateTime;

/**
 * Defines the common API to entities that use a dateCreated/dateModified scheme.
 *
 */
trait ModifiableTrait {

    /**
     * @param   DateTime  $created
     * @return  $this
     */
    public function setDateCreated(DateTime $created = NULL)
    {
        $this->dateCreated = $created ? $created : new DateTime();
        return $this;
    }

    /**
     * @param   DateTime  $modified
     * @return  $this
     */
    public function setDateModified(DateTime $modified = NULL)
    {
        $this->dateModified = $modified ? $modified : new DateTime();
        return $this;
    }

    /**
     * Automatically bump the creation and/or modification date to the current time.
     *
     * @return  $this
     */
    public function update()
    {
        $now = new DateTime();

        // Set the creation time if this is a new entity
        if (!$this->dateCreated)
        {
            $this->dateCreated = $now;
        }

        // Set the modification time
        $this->dateModified = $now;

        return $this;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @return  DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @return  DateTime
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }
}

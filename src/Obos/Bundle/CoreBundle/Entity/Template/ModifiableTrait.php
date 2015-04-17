<?php

namespace Obos\Bundle\CoreBundle\Entity\Template;

use Doctrine\ORM\Mapping as ORM,
    DateTime;


/**
 * Implements dateCreated and dateModified properties.
 *
 */
trait ModifiableTrait
{
    /**
     * @var  DateTime  The object creation timestamp.
     *
     * @ORM\Column(type="datetime", nullable=FALSE)
     */
    protected $dateCreated;

    /**
     * @var  DateTime  The object modification timestamp.
     *
     * @ORM\Column(type="datetime", nullable=FALSE)
     */
    protected $dateModified;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Set the dateCreated timestamp.
     *
     * @param   DateTime  $created
     *
     * @return  $this
     */
    public function setDateCreated(DateTime $created = NULL)
    {
        $this->dateCreated = ($created instanceof DateTime) ? $created : new DateTime();

        return $this;
    }

    /**
     * Set the dateModified timestamp.
     *
     * @param   DateTime  $modified
     *
     * @return  $this
     */
    public function setDateModified(DateTime $modified = NULL)
    {
        $this->dateModified = ($modified instanceof DateTime) ? $modified : new DateTime();

        return $this;
    }

    /**
     * Automatically set the dateCreated and/or dateModified timestamps to the current time.
     *
     * @return  $this
     */
    public function update()
    {
        $now = new DateTime();

        // Set dateCreated if this is a new entity
        if (!$this->dateCreated)
        {
            $this->dateCreated = $now;
        }

        // Always set dateModified
        $this->dateModified = $now;

        return $this;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Get the dateCreated timestamp as an object _or_ as a formatted date/time string.
     *
     * @return  DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Get the dateModified timestamp.
     *
     * @return  DateTime
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }
}

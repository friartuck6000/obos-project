<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    DateTime;

/**
 * A pair of start/end timestamps denoting a work effort toward a project.
 *
 * @ORM\Entity()
 * @ORM\Table(name="timestamps", indexes={
 *     @ORM\Index(columns={"billed"})
 * })
 */
class Timestamp
{
    use Template\IdentifierTrait;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  Project  The project this timestamp is allocated to.
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="timestamps")
     * @ORM\JoinColumn(name="projectID", referencedColumnName="ID", onDelete="CASCADE")
     */
    protected $project;

    /**
     * @var  DateTime the starting timestamp.
     *
     * @ORM\Column(type="datetime", nullable=FALSE)
     */
    protected $startStamp;

    /**
     * @var  DateTime  The stopping timestamp.
     *
     * @ORM\Column(type="datetime", nullable=TRUE)
     */
    protected $stopStamp;

    /**
     * @var  string  A description of the work done.
     *
     * @ORM\Column(type="text", nullable=TRUE)
     */
    protected $description;

    /**
     * @var  boolean  Flag indicating whether this timestamp has been billed.
     *
     * @ORM\Column(type="boolean", nullable=FALSE)
     */
    protected $billed = FALSE;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param   Project  $project
     * @return  $this
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @param   DateTime  $startStamp
     * @return  $this
     */
    public function setStartStamp($startStamp)
    {
        $this->startStamp = $startStamp;

        return $this;
    }

    /**
     * @param   DateTime  $stopStamp
     * @return  $this
     */
    public function setStopStamp($stopStamp)
    {
        $this->stopStamp = $stopStamp;

        return $this;
    }

    /**
     * @param   string  $description
     * @return  $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param   boolean  $billed
     * @return  $this
     */
    public function setBilled($billed = TRUE)
    {
        $this->billed = $billed;

        return $this;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @return  Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @return  DateTime
     */
    public function getStartStamp()
    {
        return $this->startStamp;
    }

    /**
     * @return  DateTime
     */
    public function getStopStamp()
    {
        return $this->stopStamp;
    }

    /**
     * @return  string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return  boolean
     */
    public function isBilled()
    {
        return $this->billed;
    }
}

<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    DateTime;

/**
 * A pair of start/end timestamps denoting a work effort toward a project.
 *
 * @ORM\Entity()
 * @ORM\Table(name="timestamps")
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
     * @var  Invoice  The invoice that bills for this timestamp.
     *
     * @ORM\ManyToOne(targetEntity="Invoice", inversedBy="timestamps")
     * @ORM\JoinColumn(name="invoiceID", referencedColumnName="ID", onDelete="SET NULL")
     */
    protected $invoice;

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

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @return  Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @return  Invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
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

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Determine whether the timestamp is open or closed.
     *
     * @return  bool
     */
    public function isOpen()
    {
        if ($this->startStamp && !$this->stopStamp)
        {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Determine whether the timestamp has been billed for; just syntactic sugar for checking whether
     * an invoice has been assigned.
     *
     * @return  bool
     */
    public function isBilled()
    {
        return ($this->invoice instanceof Invoice);
    }
}
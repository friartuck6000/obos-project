<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection,
    Obos\Bundle\CoreBundle\Entity\Timestamp,
    DateTime,
    DateInterval;


/**
 * The project entity.
 *
 * @ORM\Entity()
 * @ORM\Table(name="projects", indexes={
 *     @ORM\Index(columns={"status"})
 * })
 */
class Project extends Template\StatusedEntity
{
    use Template\IdentifierTrait,
        Template\ModifiableTrait,
        Template\DeliverableTrait;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  Consultant  The consultant who owns this project.
     *
     * @ORM\ManyToOne(targetEntity="Consultant", inversedBy="projects")
     * @ORM\JoinColumn(name="consultantID", referencedColumnName="ID", onDelete="CASCADE")
     */
    protected $consultant;

    /**
     * @var  Client  The client this project is associated with.
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(name="clientID", referencedColumnName="ID", onDelete="CASCADE")
     */
    protected $client;

    /**
     * @var  string  The full title of this project.
     *
     * @ORM\Column(type="string", length=64, nullable=FALSE)
     */
    protected $title;

    /**
     * @var  string  A nickname or abbreviation for the project's title.
     *
     * @ORM\Column(type="string", length=32, nullable=TRUE)
     */
    protected $shortTitle;

    /**
     * @var  string  The hourly billing rate for the project.
     *
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    protected $hourlyRate = '0.00';

    /**
     * @var  bool  Flag specifying whether time logged to this project should be auto-billed
     *             to the client.
     *
     * @ORM\Column(type="boolean", nullable=FALSE)
     */
    protected $autoBilled = FALSE;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  ArrayCollection  A collection of this project's timestamps.
     *
     * @ORM\OneToMany(targetEntity="Timestamp", mappedBy="project")
     * @ORM\OrderBy({
     *     "startStamp" = "DESC"
     * })
     */
    protected $timestamps;

    /**
     * @var  ArrayCollection  A collection of tasks associated with this project.
     *
     * @ORM\OneToMany(targetEntity="ProjectTask", mappedBy="project")
     * @ORM\OrderBy({
     *    "dateDue" = "ASC"
     * })
     */
    protected $tasks;

    /**
     * @var  ArrayCollection  A collection of assets owned by this project.
     *
     * @ORM\OneToMany(targetEntity="ProjectAsset", mappedBy="project")
     * @ORM\OrderBy({
     *     "dateModified" = "DESC"
     * })
     */
    protected $assets;

    /**
     * @var  ArrayCollection  A collection of invoices against this project.
     *
     * @ORM\OneToMany(targetEntity="Invoice", mappedBy="project")
     * @ORM\OrderBy({
     *     "dateModified" = "DESC"
     * })
     */
    protected $invoices;

    /**
     * Constructor; required to initialize collections.
     *
     */
    public function __construct()
    {
        $this->timestamps = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->assets = new ArrayCollection();
        $this->invoices = new ArrayCollection();
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param   Consultant  $consultant
     * @return  $this
     */
    public function setConsultant($consultant)
    {
        $this->consultant = $consultant;

        return $this;
    }

    /**
     * @param   Client  $client
     * @return  $this
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @param   string  $title
     * @return  $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param   string  $shortTitle
     * @return  $this
     */
    public function setShortTitle($shortTitle)
    {
        $this->shortTitle = $shortTitle;

        return $this;
    }

    /**
     * @param   string $hourlyRate
     * @return  $this
     */
    public function setHourlyRate($hourlyRate)
    {
        $this->hourlyRate = $hourlyRate;

        return $this;
    }

    /**
     * @param   boolean  $autoBilled
     * @return  $this
     */
    public function setAutoBilled($autoBilled)
    {
        $this->autoBilled = $autoBilled;

        return $this;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @return  Consultant
     */
    public function getConsultant()
    {
        return $this->consultant;
    }

    /**
     * @return  Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return  string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return  string
     */
    public function getShortTitle()
    {
        return ($this->shortTitle) ? $this->shortTitle : $this->title;
    }

    /**
     * @param   int  $round
     * @return  string
     */
    public function getHourlyRate($round = 2)
    {
        return number_format($this->hourlyRate, $round);
    }

    /**
     * @return  boolean
     */
    public function isAutoBilled()
    {
        return $this->autoBilled;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Get the entire timestamp list.
     *
     * @return  ArrayCollection
     */
    public function getAllTimestamps()
    {
        return $this->timestamps;
    }

    /**
     * Filter the timestamp list to include only timestamps that have not yet been billed.
     *
     * @return  ArrayCollection
     */
    public function getBillableTimestamps()
    {
        $billable = $this->timestamps->filter(function(Timestamp $t)
        {
            return (!$t->getInvoice());
        });

        return $billable;
    }

    /**
     * Try to find an open timestamp and return it if one is found.
     *
     * The {@see $timestamps} collection is sorted by start time, newest to oldest.
     * Logically, if there is an open timestamp, it's the first one in the list, because
     * we only allow one to be open at a time.
     *
     * @return  Timestamp|NULL
     */
    public function getOpenTimestamp()
    {
        $first = $this->timestamps->first();
        if ($first instanceof Timestamp && $first->isOpen())
        {
            return $first;
        }

        return NULL;
    }

    /**
     * Get the amount of time logged on the project.
     *
     * @param   bool  $billableOnly  If TRUE, the function only calculates the total of unbilled time;
     *                               otherwise, it will calculate the total for the life of the project.
     * @return  DateInterval
     */
    public function getLoggedTime($billableOnly = TRUE)
    {
        $start = new DateTime();
        $end = clone $start;

        // Choose the source data set
        $timestamps = ($billableOnly)
            ? $this->getBillableTimestamps()
            : $this->getAllTimestamps();

        /** @var  Timestamp  $timestamp */
        foreach ($timestamps as $timestamp)
        {
            $end->add($timestamp->getLength());
        }

        return $start->diff($end, TRUE);
    }

    /**
     * Calculate an actual hour value for logged time.
     *
     * @param   bool  $billableOnly
     * @param   int   $round
     * @return  string
     */
    public function getLoggedHours($billableOnly = true, $round = 2)
    {
        // Get a DateInterval
        $interval = $this->getLoggedTime($billableOnly);

        // Calculate hours
        $hours = $interval->h
            + ($interval->i / 60)
            + ($interval->s / 3600)
            + ($interval->d * 24);

        return number_format($hours, $round);
    }

    public function getAmountBillable($hourRounding = 2)
    {
        $amount = ($this->getLoggedHours(true, $hourRounding) * $this->hourlyRate);
        return number_format($amount, 2);
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Get the entire task list.
     *
     * @return  ArrayCollection
     */
    public function getAllTasks()
    {
        return $this->tasks;
    }

    /**
     * Get the entire asset list.
     *
     * @return  ArrayCollection
     */
    public function getAllAssets()
    {
        return $this->assets;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Get the entire invoice list.
     *
     * @return  ArrayCollection
     */
    public function getAllInvoices()
    {
        return $this->invoices;
    }

    /**
     * Get paid invoices only.
     *
     * @return  ArrayCollection
     */
    public function getPaidInvoices()
    {
        return $this->invoices->filter(function(Invoice $i) {
            return ($i->isPaid());
        });
    }

    /**
     * Get unpaid invoices only.
     *
     * @return  ArrayCollection
     */
    public function getUnpaidInvoices()
    {
        return $this->invoices->filter(function(Invoice $i) {
            return (!$i->isPaid());
        });
    }

    public function getEarnings($round = 2)
    {
        $total = 0.00;

        /** @var  Invoice  $invoice */
        foreach ($this->invoices as $invoice) {
            $payments = $invoice->getPayments();

            /** @var  Payment  $payment */
            foreach ($payments as $payment) {
                $total += $payment->getAmountPaid();
            }
        }

        return number_format($total, $round);
    }
}

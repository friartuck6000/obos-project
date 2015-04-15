<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Symfony\Component\Validator\Constraints as Assert,
    DateTime,
    InvalidArgumentException;


/**
 * Represents a consulting project; owned by one {@see Client}.
 *
 * @ORM\Entity()
 * @ORM\Table(name="projects", indexes={
 *     @ORM\Index(columns={"clientID", "consultantID"})
 * })
 */
class Project {

    const STATUS_CANCELLED = 0;
    const STATUS_INACTIVE  = 1;
    const STATUS_ACTIVE    = 2;
    const STATUS_COMPLETE  = 3;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  int  The Project ID.
     *
     * @ORM\Column(name="ID", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var  Client  The Client that owns the Project.
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="clientID", referencedColumnName="ID", onDelete="CASCADE")
     * })
     */
    protected $client;

    /**
     * @var  Consultant  The Consultant handling the Project.
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="consultantID", referencedColumnName="ID", onDelete="CASCADE")
     * })
     */
    protected $consultant;

    /**
     * @var  string  The Project's full title.
     *
     * @ORM\Column(type="string", length=96)
     */
    protected $title;

    /**
     * @var  string  A short name (acronym, abbreviation, etc.) for the Project.
     *
     * @ORM\Column(type="string", length=32, nullable=TRUE)
     */
    protected $shortTitle;

    /**
     * @var  DateTime  Timestamp representing when the Project was created.
     *
     * @ORM\Column(type="datetime")
     */
    protected $dateCreated;

    /**
     * @var  DateTime  Timestamp representing the last modification to the Project (or its
     *                 subsidiary entities).
     *
     * @ORM\Column(type="datetime")
     */
    protected $dateModified;

    /**
     * @var  DateTime  Timestamp representing the due (delivery) date of the Project.
     *
     * @ORM\Column(type="datetime", nullable=TRUE)
     */
    protected $dateDue;

    /**
     * @var  boolean  Flag indicating whether this project should automatically generate
     * billing statements.
     *
     * @ORM\Column(type="boolean")
     */
    protected $isAutoBilled = FALSE;

    /**
     * @var  int  Flag indicating the project status; see the STATUS_ constants defined
     *            in this class for possible values.
     *
     * @ORM\Column(type="smallint")
     */
    protected $status = self::STATUS_ACTIVE;

    // -----------------------------------------------------------------------------------------------------------------

    private function getValidStatuses()
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
     * @param   Client  $client
     * @return  $this
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @param   Consultant  $consultant
     * @return  $this
     */
    public function setConsultant(Consultant $consultant)
    {
        $this->consultant = $consultant;
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
     * @param   DateTime  $dateCreated
     * @return  $this
     */
    public function setDateCreated(DateTime $dateCreated = NULL)
    {
        $this->dateCreated = $dateCreated ? $dateCreated : new DateTime();
        return $this;
    }

    /**
     * @param   DateTime  $dateModified
     * @return  $this
     */
    public function setDateModified(DateTime $dateModified = NULL)
    {
        $this->dateModified = $dateModified ? $dateModified : new DateTime();
        return $this;
    }

    /**
     * @param   DateTime  $dateDue
     * @return  $this
     */
    public function setDateDue(DateTime $dateDue)
    {
        $this->dateDue = $dateDue;
        return $this;
    }

    /**
     * @param   bool  $flag
     * @return  $this
     */
    public function setAutoBilled($flag)
    {
        $this->isAutoBilled = (bool) $flag;
        return $this;
    }

    /**
     * @param   int  $status
     * @return  $this
     *
     * @throws  InvalidArgumentException  if $status does not match one of the defined STATUS_
     *                                    constant values.
     */
    public function setStatus($status)
    {
        if (!in_array($status, $this->getValidStatuses()))
        {
            throw new InvalidArgumentException('Invalid status given.');
        }

        $this->status = $status;

        return $this;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @return  int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return  Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return  Consultant
     */
    public function getConsultant()
    {
        return $this->consultant;
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
        return $this->shortTitle ? $this->shortTitle : $this->title;
    }

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

    /**
     * @return  DateTime
     */
    public function getDateDue()
    {
        return $this->dateDue;
    }

    /**
     * @return  bool
     */
    public function isAutoBilled()
    {
        return $this->isAutoBilled;
    }

    /**
     * @return  int
     */
    public function getStatus()
    {
        return $this->status;
    }

    // -----------------------------------------------------------------------------------------------------------------

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

    /**
     * Check whether the project has a given status.
     *
     * @param   int  $status  One of the STATUS_ constants defined in this class.
     * @return  bool          Whether the project's status matches the queried status.
     *
     * @throws  InvalidArgumentException  if $status is not one of the defined STATUS_
     *                                    constants.
     */
    public function statusIs($status)
    {
        if (!in_array($status, $this->getValidStatuses()))
        {
            throw new InvalidArgumentException('Invalid status query.');
        }

        return $this->status == $status;
    }
}

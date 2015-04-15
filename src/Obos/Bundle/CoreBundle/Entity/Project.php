<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection,
    Symfony\Component\Validator\Constraints as Assert,
    DateTime;


/**
 * Represents a consulting project; owned by one {@see Client}.
 *
 * @ORM\Entity()
 * @ORM\Table(name="projects", indexes={
 *     @ORM\Index(columns={"clientID", "consultantID"})
 * })
 */
class Project extends StatusedEntity {

    use ModifiableTrait,
        DeliverableTrait;

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

    /**
     * @var  ArrayCollection  The Tasks associated with this Project.
     *
     * @ORM\OneToMany(targetEntity="Task", mappedBy="project")
     */
    protected $tasks;

    /**
     * Constructor initializes the ArrayCollections for all the relationship properties.
     *
     */
    public function __construct()
    {
        $this->tasks = new ArrayCollection();
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
     * @param   bool  $flag
     * @return  $this
     */
    public function setAutoBilled($flag)
    {
        $this->isAutoBilled = (bool) $flag;
        return $this;
    }

    /**
     * @param   Task  $task
     * @return  $this
     */
    public function addTask(Task $task)
    {
        $this->tasks->add($task);
        return $this;
    }

    /**
     * @param   Task  $task
     * @return  $this
     */
    public function removeTask(Task $task)
    {
        $this->tasks->removeElement($task);
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
     * @return  bool
     */
    public function isAutoBilled()
    {
        return $this->isAutoBilled;
    }
    
    /**
     * @return  ArrayCollection
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}

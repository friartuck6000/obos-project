<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Symfony\Component\Validator\Constraints as Assert,
    DateTime;


/**
 * A unit-of-work belonging to a Project.
 *
 * @ORM\Entity()
 * @ORM\Table(name="project_tasks", indexes={})
 */
class Task extends StatusedEntity {

    use ModifiableTrait,
        DeliverableTrait;

    // -----------------------------------------------------------------------------------------------------------------

    const CATEGORY_COMPONENT   = 'component';
    const CATEGORY_DELIVERABLE = 'deliverable';
    const CATEGORY_OTHER       = 'other';
    const CATEGORY_RELEASE     = 'release';

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  int  The Task ID.
     *
     * @ORM\Column(name="ID", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var  Project  The Project the Task belongs to.
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="tasks")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="projectID", referencedColumnName="ID", onDelete="CASCADE")
     * })
     */
    protected $project;

    /**
     * @var  string  The title of the Task.
     *
     * @ORM\Column(type="string", length=64)
     */
    protected $title;

    /**
     * @var  DateTime  Timestamp representing when the Task was created.
     *
     * @ORM\Column(type="datetime")
     */
    protected $dateCreated;

    /**
     * @var  DateTime  Timestamp representing when the Task was last modified.
     *
     * @ORM\Column(type="datetime", nullable=TRUE)
     */
    protected $dateModified;

    /**
     * @var  DateTime  Timestamp representing the due (delivery) date of the Task.
     *
     * @ORM\Column(type="datetime")
     */
    protected $dateDue;

    /**
     * @var  int  Task status. See {@see StatusedEntity} for possible status values.
     *
     * @ORM\Column(type="smallint")
     */
    protected $status = self::STATUS_ACTIVE;

    /**
     * @var  string  A description of the Task.
     *
     * @ORM\Column(type="text", nullable=TRUE)
     */
    protected $description;

    /**
     * @var  string  The category that the task best falls into. See the CATEGORY_ constants defined
     *               in this class for possible values.
     *
     * @ORM\Column(type="string", length=16, nullable=TRUE)
     */
    protected $category;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Get a list of valid category values.
     *
     * @return  string[]
     */
    protected function getValidCategories()
    {
        return [
            self::CATEGORY_COMPONENT,
            self::CATEGORY_DELIVERABLE,
            self::CATEGORY_OTHER,
            self::CATEGORY_RELEASE
        ];
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param   Project  $project
     * @return  $this
     */
    public function setProject(Project $project)
    {
        $this->project = $project;
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
     * @param   string  $description
     * @return  $this
     */
    public function setDescription($description = '')
    {
        if (empty($description))
        {
            $this->description = NULL;
        }
        else
        {
            $this->description = $description;
        }

        return $this;
    }

    /**
     * @param   string  $category
     * @return  $this
     *
     * @throws  \InvalidArgumentException  if $category is not one of the defined CATEGORY_
     *                                     constant values.
     */
    public function setCategory($category)
    {
        if (!in_array($category, $this->getValidCategories()))
        {
            throw new \InvalidArgumentException('Invalid category given.');
        }

        $this->category = $category;

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
     * @return  Project
     */
    public function getProject()
    {
        return $this->project;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return  string
     */
    public function getCategory()
    {
        return $this->category;
    }
}

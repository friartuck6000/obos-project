<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * A task associated with a project.
 */
class ProjectTask extends Template\StatusedEntity
{
    use Template\IdentifierTrait,
        Template\ModifiableTrait,
        Template\DeliverableTrait;

    // -----------------------------------------------------------------------------------------------------------------

    const CATEGORY_COMPONENT = 'component';
    const CATEGORY_DOCUMENT  = 'document';
    const CATEGORY_TEST      = 'test';
    const CATEGORY_RELEASE   = 'release';
    const CATEGORY_OTHER     = 'other';

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  Project  The project this task is associated with.
     *
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="projectID", referencedColumnName="ID", onDelete="CASCADE")
     */
    protected $project;

    /**
     * @var  string  A name/label for the task.
     *
     * @ORM\Column(type="string", length=64, nullable=FALSE)
     */
    protected $name;

    /**
     * @var  string  The category that best applies to the task. See the CATEGORY_ constants in this
     *               class for possible values.
     *
     * @ORM\Column(type="string", length=24, nullable=FALSE)
     */
    protected $category;

    /**
     * @var  string  A description for the task.
     *
     * @ORM\Column(type="text", nullable=TRUE)
     */
    protected $description;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Get a list of possible category options.
     *
     * @return  string[]
     */
    public function getCategoryOptions()
    {
        return [
            self::CATEGORY_COMPONENT,
            self::CATEGORY_DOCUMENT,
            self::CATEGORY_TEST,
            self::CATEGORY_RELEASE,
            self::CATEGORY_OTHER
        ];
    }

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
     * @param   string  $name
     * @return  $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param   string  $category
     * @return  $this
     *
     * @throws  InvalidArgumentException  if the category supplied is invalid.
     */
    public function setCategory($category)
    {
        if (!in_array($category, $this->getCategoryOptions()))
        {
            throw new InvalidArgumentException('Invalid category.');
        }

        $this->category = $category;

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
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return  string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return  string
     */
    public function getDescription()
    {
        return $this->description;
    }
}

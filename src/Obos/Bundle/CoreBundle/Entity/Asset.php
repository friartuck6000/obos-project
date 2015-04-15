<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Symfony\Component\Validator\Constraints as Assert,
    DateTime;

/**
 * A file asset of some sort associated with a Project.
 *
 * @ORM\Entity()
 * @ORM\Table(name="project_assets", indexes={
 *     @ORM\Index(columns={"projectID"})
 * })
 */
class Asset {

    use IdentifierTrait,
        ModifiableTrait;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  int  Asset ID.
     *
     * @ORM\Column(name="ID", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var  Project  The Project that owns this Asset.
     *
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="projectID", referencedColumnName="ID", onDelete="CASCADE")
     * })
     */
    protected $project;

    /**
     * @var  string  The Asset's title.
     *
     * @ORM\Column(type="string", length=64)
     */
    protected $title;

    /**
     * @var  DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $dateCreated;

    /**
     * @var  DateTime
     *
     * @ORM\Column(type="datetime", nullable=TRUE)
     */
    protected $dateModified;

    /**
     * @var  string  A description of the Asset.
     *
     * @ORM\Column(type="text", nullable=TRUE)
     */
    protected $description;

    /**
     * @var  string  The MIME type of the uploaded file.
     *
     * @ORM\Column(type="string", length=64)
     */
    protected $mimeType;

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
        $this->description = empty($description) ? NULL : $description;
        return $this;
    }

    /**
     * @param   string  $mimeType
     * @return  $this
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
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
    public function getMimeType()
    {
        return $this->mimeType;
    }
}

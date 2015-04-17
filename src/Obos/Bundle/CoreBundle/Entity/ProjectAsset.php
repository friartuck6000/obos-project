<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * A file asset associated with a project. Note that filenames are not stored in this table;
 * filename management should be left to the service that manages asset uploads.
 *
 * @ORM\Entity()
 * @ORM\Table(name="project_assets")
 */
class ProjectAsset
{
    use Template\IdentifierTrait,
        Template\ModifiableTrait;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  Project  The project that owns this asset.
     *
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="projectID", referencedColumnName="ID", onDelete="CASCADE")
     */
    protected $project;

    /**
     * @var  string  The asset name.
     *
     * @ORM\Column(type="string", length=64, nullable=FALSE)
     */
    protected $name;

    /**
     * @var  string  A description of the asset.
     *
     * @ORM\Column(type="text", nullable=TRUE)
     */
    protected $description;

    /**
     * @var  string  The MIME type of the asset file.
     */
    protected $mimeType;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param   Project $project
     * @return  $this
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @param   string $name
     * @return  $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param   string $description
     * @return  $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param   string $mimeType
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
    public function getName()
    {
        return $this->name;
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

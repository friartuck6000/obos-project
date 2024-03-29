<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    DateTime;


/**
 * The Consultant user; descendant of {@see User}.
 *
 * @ORM\Entity()
 */
class Consultant extends User
{
    // Gender choices
    const GENDER_MALE        = 'M';
    const GENDER_FEMALE      = 'F';
    const GENDER_UNDISCLOSED = 'U';

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  DateTime  Consultant's date of birth
     *
     * @ORM\Column(type="datetime", nullable=TRUE)
     */
    protected $dateOfBirth;

    /**
     * @var  string  Consultant's gender selection; see the GENDER_ constants for a list of possible values.
     *
     * @ORM\Column(type="string", length=1, nullable=FALSE)
     */
    protected $gender = self::GENDER_UNDISCLOSED;

    /**
     * @var  string  Consultant's self-proclaimed professional title.
     *
     * @ORM\Column(type="string", length=64, nullable=TRUE)
     */
    protected $title;

    /**
     * @var  string  Consultant's specified industry.
     *
     * @ORM\Column(type="string", length=32, nullable=TRUE)
     */
    protected $industry;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  ArrayCollection a collection of the user's projects.
     *
     * @ORM\OneToMany(targetEntity="Project", mappedBy="consultant")
     * @ORM\OrderBy({
     *    "dateDue" = "ASC",
     *    "title"   = "ASC"
     * })
     */
    protected $projects;

    /**
     * Constructor; required to initialize collections.
     *
     */
    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Get a list of the available options for {@see $gender}.
     *
     * @return  string[]
     */
    public function getGenderOptions()
    {
        return [
            self::GENDER_MALE,
            self::GENDER_FEMALE,
            self::GENDER_UNDISCLOSED
        ];
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param   DateTime  $dateOfBirth
     * @return  $this
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * @param   string  $gender
     * @return  $this
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

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
     * @param   string  $industry
     * @return  $this
     */
    public function setIndustry($industry)
    {
        $this->industry = $industry;

        return $this;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @return  DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @return  string
     */
    public function getGender()
    {
        return $this->gender;
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
    public function getIndustry()
    {
        return $this->industry;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Get the entire project collection.
     *
     * @return  ArrayCollection
     */
    public function getAllProjects()
    {
        return $this->projects;
    }

    /**
     * Filter the project collection by a particular status.
     *
     * @param   string  $status
     * @return  Collection|static
     */
    public function getProjectsWithStatus($status = Project::STATUS_ACTIVE)
    {
        return $this->projects->filter(function(Project $p) use ($status)
        {
            if ($p->statusIs($status))
            {
                return TRUE;
            }

            return FALSE;
        });
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * List the roles that apply to this user entity.
     *
     * @return  string[]
     */
    public function getRoles()
    {
        return ['ROLE_CONSULTANT'];
    }
}

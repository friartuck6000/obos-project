<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection;


/**
 * The client entity.
 *
 * @ORM\Entity()
 * @ORM\Table(name="clients")
 */
class Client
{
    use Template\IdentifierTrait;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  Consultant  The user who owns this entity.
     *
     * @ORM\ManyToOne(targetEntity="Consultant", inversedBy="clients")
     * @ORM\JoinColumn(name="consultantID", referencedColumnName="ID", onDelete="CASCADE")
     */
    protected $consultant;

    /**
     * @var  string  The client's full business name.
     *
     * @ORM\Column(type="string", length=64, nullable=FALSE)
     */
    protected $name;

    /**
     * @var  string  A short name (abbreviation, nickname) for the client.
     *
     * @ORM\Column(type="string", length=32, nullable=TRUE)
     */
    protected $shortName;

    /**
     * @var  string  The client's website.
     *
     * @ORM\Column(type="string", length=96, nullable=TRUE)
     */
    protected $website;

    /**
     * @var  string  Client address, line 1.
     *
     * @ORM\Column(type="string", length=32, nullable=TRUE)
     */
    protected $address1;

    /**
     * @var  string  Client address, line 2.
     *
     * @ORM\Column(type="string", length=32, nullable=TRUE)
     */
    protected $address2;

    /**
     * @var  string  Client address, city.
     *
     * @ORM\Column(type="string", length=64, nullable=TRUE)
     */
    protected $city;

    /**
     * @var  string  Client address, state.
     *
     * @ORM\Column(type="string", length=2, nullable=TRUE)
     */
    protected $state;

    /**
     * @var  string  Client address, zip.
     *
     * @ORM\Column(type="string", length=10, nullable=TRUE)
     */
    protected $zip;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  ArrayCollection  A list of ClientContact entities associated with this client.
     *
     * @ORM\OneToMany(targetEntity="ClientContact", mappedBy="client")
     * @ORM\OrderBy({
     *     "lastName"  = "ASC",
     *     "firstName" = "ASC"
     * })
     */
    protected $contacts;

    /**
     * Constructor; required to initialize collections.
     */
    public function __construct()
    {
        $this->contacts = new ArrayCollection();
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
     * @param   string  $name
     * @return  $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param   mixed  $shortName
     * @return  $this
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * @param   string  $website
     * @return  $this
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @param   string  $address1
     * @return  $this
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * @param   string  $address2
     * @return  $this
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * @param   string  $city
     * @return  $this
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @param   string  $state
     * @return  $this
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @param   string  $zip
     * @return  $this
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

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
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return  string
     */
    public function getShortName()
    {
        return ($this->shortName) ? $this->shortName : $this->name;
    }

    /**
     * @return  string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @return  string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @return  string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @return  string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return  string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return  string
     */
    public function getZip()
    {
        return $this->zip;
    }
}

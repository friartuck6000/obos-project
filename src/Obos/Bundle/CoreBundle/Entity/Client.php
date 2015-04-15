<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Symfony\Component\Validator\Constraints as Assert;


/**
 * Represents a real-world client of the Consultant; the owner of one or more Projects.
 *
 * @ORM\Entity()
 * @ORM\Table(name="clients", indexes={
 *     @ORM\Index(columns={"consultantID"})
 * })
 */
class Client {

    /**
     * @var  int  Client ID.
     *
     * @ORM\Column(name="ID", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var  Consultant  The Consultant this Client belongs to.
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="consultantID", referencedColumnName="ID", onDelete="CASCADE")
     * })
     */
    protected $consultant;

    /**
     * @var  string  The full Client name.
     *
     * @ORM\Column(type="string", length=64)
     */
    protected $name;

    /**
     * @var  string  A short name (abbreviation, nickname, etc.) for the Client.
     *
     * @ORM\Column(type="string", length=32, nullable=TRUE)
     */
    protected $shortName;

    /**
     * @var  string  Client's website.
     *
     * @ORM\Column(type="string", length=96, nullable=TRUE)
     */
    protected $website;

    /**
     * @var  string  First line of Client's corporate/billing address.
     *
     * @ORM\Column(type="string", length=32)
     */
    protected $address1;

    /**
     * @var  string  Second (optional) line of Client's corporate/billing address.
     *
     * @ORM\Column(type="string", length=32, nullable=TRUE)
     */
    protected $address2;

    /**
     * @var  string  City of Client's corporate/billing address.
     *
     * @ORM\Column(type="string", length=32)
     */
    protected $city;

    /**
     * @var  string  ANSI state code for Client's corporate/billing address.
     *
     * @ORM\Column(type="string", length=2)
     */
    protected $state;

    /**
     * @var  string  ZIP code for Client's corporate/billing address.
     *
     * @ORM\Column(type="string", length=10)
     */
    protected $zip;

    // -----------------------------------------------------------------------------------------------------------------

    // TODO: Add ClientContacts mapping

    // -----------------------------------------------------------------------------------------------------------------

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
     * @param   string  $name
     * @return  $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param   string  $shortName
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

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @return  int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return  User
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
        return $this->shortName;
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
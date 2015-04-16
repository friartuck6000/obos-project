<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection;


/**
 * A contact associated with a client.
 *
 * @ORM\Entity()
 * @ORM\Table(name="client_contacts")
 */
class ClientContact
{
    use Template\IdentifierTrait;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  Client  The client this contact is associated with.
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(name="clientID", referencedColumnName="ID", onDelete="CASCADE")
     */
    protected $client;

    /**
     * @var  string  Contact's first name.
     *
     * @ORM\Column(type="string", length=64, nullable=FALSE)
     */
    protected $firstName;

    /**
     * @var  string  Contact's last name.
     *
     * @ORM\Column(type="string", length=64, nullable=FALSE)
     */
    protected $lastName;

    /**
     * @var  string  Contact's email address.
     *
     * @ORM\Column(type="string", length=96, nullable=TRUE)
     */
    protected $email;

    /**
     * @var  string  Contact's phone number.
     *
     * @ORM\Column(type="string", length=24, nullable=TRUE)
     */
    protected $phone;

    /**
     * @var  string  Contact's fax number.
     *
     * @ORM\Column(type="string", length=24, nullable=TRUE)
     */
    protected $fax;

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
     * @param   Client  $client
     * @return  $this
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @param   string  $firstName
     * @return  $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @param   string  $lastName
     * @return  $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @param   string  $email
     * @return  $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param   string  $phone
     * @return  $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @param   string  $fax
     * @return  $this
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    // -----------------------------------------------------------------------------------------------------------------

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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return  string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return  string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return  string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return  string
     */
    public function getFax()
    {
        return $this->fax;
    }
}

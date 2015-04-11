<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Symfony\Component\Validator\Constraints as Assert;


/**
 * A contact point for a {@see Client}.
 * @ORM\Entity()
 * @ORM\Table(name="client_contacts", indexes={
 *    @ORM\Index(columns={"clientID"})
 * })
 */
class ClientContact {

    /**
     * @var  int  ClientContact ID.
     *
     * @ORM\Column(name="ID", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var  Client  The Client this ClientContact is associated with.
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="clientID", referencedColumnName="ID", onDelete="CASCADE")
     * })
     */
    protected $client;

    /**
     * @var  string  The ClientContact's name.
     *
     * @ORM\Column(type="string", length=64)
     */
    protected $name;

    /**
     * @var  string  The ClientContact's email.
     *
     * @ORM\Column(type="string", length=96)
     */
    protected $email;

    /**
     * @var  string  The ClientContact's phone number.
     *
     * @ORM\Column(type="string", length=16)
     */
    protected $phone;

    /**
     * @var  string  The ClientContact's fax number.
     *
     * @ORM\Column(type="string", length=16)
     */
    protected $fax;

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
     * @param   string  $name
     * @return  $this
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return  string
     */
    public function getName()
    {
        return $this->name;
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
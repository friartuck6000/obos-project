<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Symfony\Component\Validator\Constraints as Assert,
    DateTime;


/**
 * The general User entity; more specifically mapped to either {@see Administrator}
 * or {@see Consultant}.
 *
 * @ORM\Entity()
 * @ORM\Table(name="users")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="role")
 * @ORM\DiscriminatorMap({
 *     "ROLE_ADMIN" = "Administrator",
 *     "ROLE_CONSULTANT" = "Consultant" 
 * })
 */
class User
{
    /**
     * @var  int
     *
     * @ORM\Column(name="ID", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var  string
     *
     * @ORM\Column(type="string", length=64)
     */
    protected $email;

    /**
     * @var  string
     *
     * @ORM\Column(type="string", length=64)
     */
    protected $password;

    /**
     * @var  string
     *
     * @ORM\Column(type="string", length=32, nullable=TRUE)
     */
    protected $firstName;

    /**
     * @var  string
     *
     * @ORM\Column(type="string", length=32, nullable=TRUE)
     */
    protected $lastName;

    /**
     * @var  DateTime
     *
     * @ORM\Column(type="datetime", nullable=TRUE)
     */
    protected $dob;

    /**
     * @var  DateTime
     *
     * @ORM\Column(type="datetime", nullable=TRUE)
     */
    protected $lastLogin;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param   string  $email
     * @return  $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * @return  string
     */
    public function getEmail()
    {
        return $this->email;
    }
}

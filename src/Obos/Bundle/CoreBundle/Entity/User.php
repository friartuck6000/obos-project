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
    use IdentifierTrait;

    // -----------------------------------------------------------------------------------------------------------------

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

    /**
     * @param   string  $password
     * @return  $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
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
     * @param   DateTime  $dob
     * @return  $this
     */
    public function setDob(DateTime $dob = NULL)
    {
        $this->dob = $dob;
        return $this;
    }

    /**
     * @param   DateTime  $lastLogin
     * @return  $this
     */
    public function setLastLogin(DateTime $lastLogin = NULL)
    {
        $this->lastLogin = $lastLogin ? $lastLogin : new DateTime();
        return $this;
    }

    // -----------------------------------------------------------------------------------------------------------------
    
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
    public function getPassword()
    {
        return $this->password;
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
     * @return  DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * @return  DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }
}

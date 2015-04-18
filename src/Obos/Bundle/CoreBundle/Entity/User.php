<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Symfony\Component\Security\Core\User\UserInterface,
    Serializable,
    DateTime;


/**
 * The base user entity. See the Consultant and Administrator entities for specific
 * implementations.
 *
 * @ORM\Entity()
 * @ORM\Table(name="users")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="role", type="string", length=24)
 * @ORM\DiscriminatorMap({
 *     "ROLE_ADMINISTRATOR" = "Administrator",
 *     "ROLE_CONSULTANT"    = "Consultant"
 * })
 */
abstract class User implements UserInterface, Serializable
{
    use Template\IdentifierTrait;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  string  User's email address, which doubles as his/her login.
     *
     * @ORM\Column(type="string", length=96, nullable=FALSE)
     */
    protected $email;

    /**
     * @var  string  User's (hashed) password.
     *
     * @ORM\Column(type="string", length=64, nullable=FALSE)
     */
    protected $password;

    /**
     * @var  string  User's first name.
     *
     * @ORM\Column(type="string", length=32, nullable=TRUE)
     */
    protected $firstName;

    /**
     * @var  string  User's last name.
     *
     * @ORM\Column(type="string", length=32, nullable=TRUE)
     */
    protected $lastName;

    /**
     * @var  DateTime  The timestamp of the User's last login.
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
     * @param   DateTime  $lastLogin
     * @return  $this
     */
    public function setLastLogin(DateTime $lastLogin = NULL)
    {
        $this->lastLogin = ($lastLogin instanceof DateTime) ? $lastLogin : new DateTime();

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
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Get user's role; method must be implemented by subclass entities.
     *
     * @return  string[]
     */
    abstract public function getRoles();

    /**
     * Get the user's userame (email address).
     * {@inheritdoc}
     *
     * @return  string
     */
    final public function getUsername()
    {
        return $this->email;
    }

    /**
     * Get password salt; returns NULL because the bcrypt encoder does not require it.
     *
     * @return  NULL
     */
    final public function getSalt()
    {
        return NULL;
    }

    /**
     * {@inheritdoc}
     *
     */
    final public function eraseCredentials()
    {}

    // -----------------------------------------------------------------------------------------------------------------

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password
        ]);
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password
            ) = unserialize($serialized);
    }
}

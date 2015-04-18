<?php

namespace Obos\Bundle\CoreBundle\Manager;


use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface,
    Doctrine\Common\Persistence\ManagerRegistry,
    Doctrine\ORM\EntityManagerInterface,
    Obos\Bundle\CoreBundle\Entity\Consultant,
    Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * Defines the persistence API for user management.
 *
 */
class UserManager
{
    /**
     * @var  EntityManagerInterface  The entity manager to use for persistence operations.
     */
    protected $entityManager;

    /**
     * @var  UserPasswordEncoderInterface  The password encoder service, for password operations.
     */
    protected $passwordEncoder;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Constructor; set services and properties.
     *
     * @param  ManagerRegistry               $managerRegistry
     * @param  UserPasswordEncoderInterface  $passwordEncoder
     *
     * @throws  InvalidConfigurationException  if a valid entity manager can't be found for the
     *                                         user class.
     */
    public function __construct(
        ManagerRegistry $managerRegistry,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        // Load the correct entity manager; if one can't be loaded, throw an exception
        $this->entityManager = $managerRegistry->getManagerForClass('ObosCoreBundle:Consultant');
        if (!$this->entityManager)
        {
            throw new InvalidConfigurationException('There is no entity manager configured for the user '
                .'entities of this system.');
        }

        $this->passwordEncoder = $passwordEncoder;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Persist a newly registered user.
     *
     * @param   Consultant  $user
     */
    public function registerUser(Consultant $user)
    {
        // Hash the user's password
        $rawPassword = $user->getPassword();
        $user->setPassword($this->passwordEncoder->encodePassword($user, $rawPassword));

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }
}

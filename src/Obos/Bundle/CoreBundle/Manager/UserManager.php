<?php

namespace Obos\Bundle\CoreBundle\Manager;


use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface,
    Doctrine\Common\Persistence\ManagerRegistry,
    Doctrine\ORM\EntityManagerInterface;

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
     */
    public function __construct(
        ManagerRegistry $managerRegistry,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $this->entityManager = $managerRegistry->getManagerForClass('ObosCoreBundle:Consultant');
        $this->passwordEncoder = $passwordEncoder;
    }

    // -----------------------------------------------------------------------------------------------------------------
}

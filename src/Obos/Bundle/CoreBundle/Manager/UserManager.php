<?php

namespace Obos\Bundle\CoreBundle\Manager;


use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Obos\Bundle\CoreBundle\Entity\Consultant;


/**
 * Defines the persistence API for user management.
 *
 */
class UserManager extends AbstractPersistenceManager
{
    /**
     * @var  UserPasswordEncoderInterface  The password encoder service, for password operations.
     */
    protected $passwordEncoder;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Constructor; set services and properties.
     * {@inheritdoc}
     *
     * @param  ManagerRegistry               $managerRegistry
     * @param  string                        $entityName
     * @param  UserPasswordEncoderInterface  $passwordEncoder
     */
    public function __construct(
        RequestStack $requestStack,
        ManagerRegistry $managerRegistry,
        $entityName,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        parent::__construct($requestStack, $managerRegistry, $entityName);

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

<?php

namespace Obos\Bundle\ProjectManagementBundle\Manager;

use Doctrine\Common\Persistence\ManagerRegistry,
    Doctrine\ORM\EntityManagerInterface,
    Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface,
    Obos\Bundle\CoreBundle\Entity\Consultant,
    Obos\Bundle\CoreBundle\Manager\AbstractPersistenceManager,
    Obos\Bundle\CoreBundle\Exception\InvalidArgumentException;


class ClientManager extends AbstractPersistenceManager
{
    /**
     * @var  Consultant
     */
    protected $user;

    public function setUser(TokenStorageInterface $tokenStorage)
    {
        $this->user = $tokenStorage->getToken()->getUser();
        if (!($this->user instanceof Consultant))
        {
            throw new InvalidArgumentException('User must be a valid Consultant.');
        }
    }

    public function getClients()
    {
        $clients = $this->entityManager->getRepository('ObosCoreBundle:Client')
            ->findBy(['consultant' => $this->user]);

        return $clients;
    }
}

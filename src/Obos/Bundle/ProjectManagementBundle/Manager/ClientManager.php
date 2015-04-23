<?php

namespace Obos\Bundle\ProjectManagementBundle\Manager;

use Obos\Bundle\CoreBundle\Entity\Client;
use Obos\Bundle\CoreBundle\Manager;


/**
 * The persistence manager for Clients.
 *
 */
class ClientManager extends Manager\AbstractPersistenceManager
{
    use Manager\UserDependentTrait;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Generate a QueryBuilder instance that loads all clients for the current user.
     * Primarily used for the toolbar form on the project manager root screen.
     *
     * @return  \Doctrine\ORM\QueryBuilder
     */
    public function getClientListBuilder()
    {
        $builder = $this->entityManager->createQueryBuilder()
            ->select('c')
            ->from('ObosCoreBundle:Client', 'c')
            ->where('c.consultant = ?1')
            ->setParameter(1, $this->user);

        return $builder;
    }

    // -----------------------------------------------------------------------------------------------------------------

    public function getClients()
    {
        $clients = $this->entityManager->getRepository('ObosCoreBundle:Client')
            ->findBy(['consultant' => $this->user]);

        return $clients;
    }

    public function addClient(Client $client)
    {
        // Set the user association
        $client->setConsultant($this->user);

        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }
}

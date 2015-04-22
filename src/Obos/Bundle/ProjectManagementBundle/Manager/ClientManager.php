<?php

namespace Obos\Bundle\ProjectManagementBundle\Manager;

use Obos\Bundle\CoreBundle\Entity\Client;
use Obos\Bundle\CoreBundle\Manager,
    Obos\Bundle\CoreBundle\Exception\InvalidArgumentException;
use Symfony\Component\Form\FormInterface;


class ClientManager extends Manager\AbstractPersistenceManager
{
    use Manager\UserDependentTrait;

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

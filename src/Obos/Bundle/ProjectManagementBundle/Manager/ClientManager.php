<?php

namespace Obos\Bundle\ProjectManagementBundle\Manager;

use Obos\Bundle\CoreBundle\Manager,
    Obos\Bundle\CoreBundle\Exception\InvalidArgumentException;


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
}

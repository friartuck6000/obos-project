<?php

namespace Obos\Bundle\ProjectManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Symfony\Component\DependencyInjection\ContainerInterface,
    Symfony\Component\DependencyInjection\ContainerAware;

/**
 * @Route("/clients")
 */
class ClientController extends Controller
{
    /**
     * @var  ClientManager  A reference to the client management service object.
     */
    protected $clientManager;

    // -----------------------------------------------------------------------------------------
    
    /**
     * Hook into {@see ContainerAware::setContainer()} to set references to the services
     * this controller needs to interact with.
     *
     * @param  ContainerInterface  $container  The service container.
     */
    public function setContainer(ContainerInterface $container = NULL)
    {
        parent::setContainer($container);

        // Set a reference to the client manager service
        $this->clientManager = $this->get('obos.clients.manager');
    }

    // -----------------------------------------------------------------------------------------

    /**
     * Show a listing of existing clients.
     *
     * @Route("/", name="projectmanagement.clients.root")
     */
    public function indexAction()
    {
        // Get the list of existing clients.
        $clients = $this->clientManager->getAllClients();

        return ['clients' => $clients];
    }

    /**
     * Show client details.
     *
     * @Route("/{id}", name="projectmanagement.clients.detail")
     * @Template()
     *
     * @param  integer  $id  The client ID.
     */
    public function clientDetailAction($id)
    {
        // Try to load the client
        $client = $this->clientManager->getClientById($id);
        if (!$client)
        {
            throw $this->createNotFoundException('Client does not exist');
        }

        return ['client' => $client];
    }
}

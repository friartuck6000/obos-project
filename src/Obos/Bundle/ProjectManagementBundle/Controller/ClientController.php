<?php

namespace Obos\Bundle\ProjectManagementBundle\Controller;

use Obos\Bundle\CoreBundle\Entity\Client;
use Obos\Bundle\ProjectManagementBundle\Form\Type\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Controller for client management.
 *
 * @Route("/clients")
 */
class ClientController extends Controller
{
    /**
     * Clients root. No action; redirects to projects root.
     *
     * @return  RedirectResponse
     *
     * @Route("/", name="clients.root")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('projects.root');
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Add a new client.
     *
     * @param   Request  $request
     * @return  Response
     *
     * @Route("/new", name="clients.add")
     */
    public function addClientAction(Request $request)
    {
        // Get the persistence manager
        $manager = $this->get('obos.manager.client');

        // Initialize the entity and build the form
        $client = new Client();
        $form = $this->createForm('client', $client);

        // Look for and process a valid form submission
        $form->handleRequest($request);
        if ($form->isValid()) {

            // Attempt to save the client; redirect if successful.
            if ($manager->saveClient($client, $form)) {
                return $this->redirectToRoute('projects.root');
            }
        }

        return $this->render('client/addClient.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Edit or remove a client.
     *
     * @param   Request  $request
     * @param   Client   $client
     * @return  Response
     *
     * @Route("/{client}/edit", name="clients.edit")
     * @ParamConverter("client", class="ObosCoreBundle:Client", options={"id" = "client"})
     */
    public function editClientAction(Request $request, Client $client)
    {
        // Get the persistence manager
        $manager = $this->get('obos.manager.client');

        // Build the form around the existing client
        $form = $this->createForm('client', $client);

        // Check for a form submission
        $form->handleRequest($request);
        if ($form->isValid()) {

            // Check the clicked button to determine whether to save or delete
            $action = $form->getClickedButton();
            if ($action) {
                if (($action->getName()) == 'delete') {
                    // Delete the client; redirect if successful.
                    if ($manager->deleteClient($client)) {
                        return $this->redirectToRoute('projects.root');
                    }
                } else {
                    // Attempt to save the client; redirect if successful.
                    if ($manager->saveClient($client, $form)) {
                        return $this->redirectToRoute('projects.root');
                    }
                }
            }
        }

        return $this->render('client/editClient.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

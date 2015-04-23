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

            // Make sure the current user matches the one attached to
            // the form submission
            if ($manager->userMatches($form->get('consultantID'))) {

                // Save the new client
                $manager->addClient($client);

                // Add a confirmation flash message
                $this->addFlash('success', sprintf(
                    'The client <b>%s</b> was added successfully.',
                    $client->getName()
                ));

                return $this->redirectToRoute('projects.root');

            } else {

                // Add a failure message
                $this->addFlash('danger', sprintf(
                    'The client <b>%s</b> could not be added because there was an error '
                        .'linking it to your account; please try again.',
                    $client->getName()
                ));
            }
        }

        return $this->render('client/addClient.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

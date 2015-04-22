<?php

namespace Obos\Bundle\ProjectManagementBundle\Controller;

use Obos\Bundle\CoreBundle\Entity\Client;
use Obos\Bundle\ProjectManagementBundle\Form\Type\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * The frontmost controller for this component.
 *
 * @Route("/projects")
 */
class DefaultController extends Controller
{
    /**
     * The base page for the project management component.
     *
     * @return  Response|mixed[]
     *
     * @Route("/", name="proj_root")
     * @Template()
     */
    public function indexAction()
    {
        $clients = $this->get('obos.manager.client')->getClients();

        return [
            'clients' => $clients,
            'projects' => []
        ];
    }

    /**
     * Create a new client.
     *
     * @param   Request  $request
     * @return  Response|mixed[]
     *
     * @Route("/client/new", name="proj_client_add")
     * @Template()
     */
    public function addClientAction(Request $request)
    {
        $client = new Client();
        $form = $this->createForm(new ClientType($this->getUser()), $client);

        $form->handleRequest($request);

        if ($form->isValid()) {

            // Get the persistence manager
            $manager = $this->get('obos.manager.client');

            // Make sure the user association is correct before continuing with
            // the save.
            if ($manager->userMatches($form->get('consultantID'))) {

                // Save the new client
                $manager->addClient($client);

                // Notify the user and redirect to the projects root.
                $this->addFlash('success', sprintf(
                    'Client <b>%s</b> added successfully.',
                    $client->getName()
                ));

                return $this->redirectToRoute('proj_root');
            } else {

                // If the user association couldn't be validated, notify the user.
                $this->addFlash(
                    'danger',
                    'The client couldn\'t be saved because there was an error linking it to '
                        .'your account. Please try again.'
                );
            }
        }

        return [
            'form' => $form->createView(),
        ];
    }
}

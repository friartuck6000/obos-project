<?php

namespace Obos\Bundle\ProjectManagementBundle\Controller;

use Doctrine\Common\Util\Debug;
use Obos\Bundle\CoreBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Controller for project management.
 *
 * @Route("/projects")
 */
class ProjectController extends Controller
{
    /**
     * Projects root.
     *
     * @param   Request  $request
     * @return  Response
     *
     * @Route("/", name="projects.root")
     */
    public function indexAction(Request $request)
    {
        // Get manager instances
        $clientManager = $this->get('obos.manager.client');

        // Generate the query builder for loading clients and projects
        $clientListBuilder = $clientManager->getClientListBuilder();
        $projectListBuilder = null;

        // Build the project manager toolbar form
        $actionForm = $this->createFormBuilder([])
            ->add('client', 'entity', [
                'class' => 'ObosCoreBundle:Client',
                'query_builder' => $clientListBuilder,
                'property' => 'name',
            ])
            ->add('createClient', 'submit')
            ->add('editClient', 'submit')
            ->add('createProject', 'submit')
            ->getForm();

        // $clients = $this->get('obos.manager.client')->getClients();

        // Handle routing for action buttons
        $actionForm->handleRequest($request);
        $selectedAction = $actionForm->getClickedButton();
        if ($selectedAction) {
            $newRoute = null;
            switch ($selectedAction->getName()) {
                case 'createClient':
                    $newRoute = 'clients.add';
                    break;
                case 'editClient':
                    $newRoute = 'clients.edit';
                    break;
                case 'createProject':
                    $newRoute = 'projects.add';
                    break;
            }

            if ($newRoute) {
                $this->get('logger')->notice(gettype($actionForm->get('client')->getData()->getName()));
                return $this->redirectToRoute($newRoute, [
                    'client' => $actionForm->get('client')->getData()->getId(),
                ]);
            }
        }

        return $this->render('project/index.html.twig', [
            'actionForm' => $actionForm->createView(),
            'clients' => $clientListBuilder->getQuery()->getResult(),
            'projects' => []
        ]);
    }

    /**
     * Project creator.
     *
     * @param   Request  $request
     * @param   Client   $client
     * @return  Response
     *
     * @Route("/new/{client}", name="projects.add")
     * @ParamConverter("client", class="ObosCoreBundle:Client", options={"id" = "client"})
     */
    public function createProjectAction(Request $request, Client $client)
    {
        return new Response();
    }
}

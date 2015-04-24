<?php

namespace Obos\Bundle\ProjectManagementBundle\Controller;

use Obos\Bundle\CoreBundle\Entity\Client;
use Obos\Bundle\CoreBundle\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $projectManager = $this->get('obos.manager.project');

        // Generate the query builder for loading clients and projects
        $clientListBuilder = $clientManager->getClientListBuilder();
        $projectListBuilder = $projectManager->getProjectListBuilder();

        // Build the project manager toolbar form
        $actionForm = $this->createFormBuilder([])
            ->add('client', 'entity', [
                'class' => 'ObosCoreBundle:Client',
                'query_builder' => $clientListBuilder,
                'property' => 'shortName',
            ])
            ->add('createClient', 'submit')
            ->add('editClient', 'submit')
            ->add('createProject', 'submit')
            ->getForm();

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
            'clients'    => $clientListBuilder->getQuery()->getResult(),
            'projects'   => $projectListBuilder->getQuery()->getResult(),
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
        // Get the persistence manager
        $manager = $this->get('obos.manager.project');

        // Initialize the entity and build the form
        $project = new Project();
        $project->setClient($client);
        $form = $this->createForm('project', $project);

        // Process form submission if there is one
        $form->handleRequest($request);
        if ($form->isValid()) {

            // Attempt to save the project and redirect if successful
            if ($manager->saveProject($project, $form)) {
                return $this->redirectToRoute('projects.root');
            }
        }

        return $this->render('project/addProject.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Edit (or remove) a project.
     *
     * @param   Request  $request
     * @param   Project  $project
     * @return  Response
     *
     * @Route("/{project}/edit", name="projects.edit")
     * @ParamConverter("project", class="ObosCoreBundle:Project", options={"id" = "project"})
     */
    public function editProjectAction(Request $request, Project $project)
    {
        // ...
    }

    /**
     * View project details.
     *
     * @param   Request  $request
     * @param   Project  $project
     * @return  Response
     *
     * @Route("/{project}/details", name="projects.single_view")
     * @ParamConverter("project", class="ObosCoreBundle:Project", options={"id" = "project"})
     */
    public function viewProjectAction(Request $request, Project $project)
    {
        return new Response();
    }
}

<?php

namespace Obos\Bundle\ProjectManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
}

<?php

namespace Obos\Bundle\ProjectManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

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
        return [];
    }
}

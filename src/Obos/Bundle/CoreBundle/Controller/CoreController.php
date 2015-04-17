<?php

namespace Obos\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * Root app controller
 *
 * @Route("/")
 */
class CoreController extends Controller
{
    /**
     * App root. If the user is authorized, she is redirected to the project listing view; otherwise,
     * the default view prompts her to log in or register.
     *
     * @Route("/", name="core_root")
     * @Template()
     */
    public function rootAction()
    {
        return [];
    }

    /**
     * Registration page.
     *
     * @Route("/register", name="core_register")
     * @Template()
     */
    public function registerAction()
    {
        return [];
    }
}

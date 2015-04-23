<?php

namespace Obos\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Obos\Bundle\CoreBundle\Entity\Consultant,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;


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
     * @return  Response|mixed[]
     *
     * @Route("/", name="core_root")
     * @Template()
     */
    public function rootAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_CONSULTANT'))
        {
            return $this->redirectToRoute('projects.root');
        }

        return [];
    }

    /**
     * Login checking action.
     *
     * @return  Response
     *
     * @Route("/auth", name="core_login")
     */
    public function loginAction()
    {
        return new Response();
    }

    /**
     * Logout action.
     *
     * @return  Response
     *
     * @Route("/logout", name="core_logout")
     */
    public function logoutAction()
    {
        return new Response();
    }

    /**
     * Registration page.
     *
     * @param   Request  $request  The request.
     * @return  Response|mixed[]
     *
     * @Route("/register", name="core_register")
     * @Template()
     */
    public function registerAction(Request $request)
    {
        $newUser = new Consultant();
        $form = $this->createForm('registration', $newUser);

        // Handle the form submission when applicable
        $form->handleRequest($request);

        if ($form->isValid())
        {
            // Persist the new user
            $this->get('obos.manager.user')->registerUser($newUser);

            // Add confirmation flash
            $this->addFlash('success', sprintf(
                'Thanks for registering, %s! You can now log in using your email address and password.',
                $newUser->getFirstName()
            ));

            return $this->redirectToRoute('core_root');
        }

        return [
            'regForm' => $form->createView()
        ];
    }
}

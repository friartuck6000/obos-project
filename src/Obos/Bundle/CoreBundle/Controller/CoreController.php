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
        return [];
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
        $form = $this->createForm('registration', new Consultant());

        // Handle the form submission when applicable
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $this->addFlash('success', 'Registration form was valid!');
            return $this->redirectToRoute('core_root');
        }

        return [
            'regForm' => $form->createView()
        ];
    }
}

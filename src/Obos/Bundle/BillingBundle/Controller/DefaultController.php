<?php

namespace Obos\Bundle\BillingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\PaymentEntry;


//Cliff O'Key 3/29/2015
//Symfony controller class for billing component
class DefaultController extends Controller
{
    //This is the default contoller class for the OBOS Billing Component.
    //All OBOS billing component actions are routed through this controller class.


    //The following is a test mthod inserted by Symfony. Do not remove.
    /**
     * @Route("/billtest/")
     * @Template()
     */
    public function indexAction()
    {
    
        return new Response('<html><body>Cliffs first symfony web page '.rand(1,100).'</body></html>');
    }

     /**
     * @Route("/billmain", name="billmain")
     * @Template()
     */
    public function billMainAction(Request $request)
    {
        
        return $this->render('ObosBillingBundle:Default:billing.html.twig');

    }

      /**
     * @Route("/billentry", name="billentry")
     * @Template()
     */
    public function billEntryAction(Request $request)
    {
        $payment = new PaymentEntry();

        $form = $this->createFormBuilder($payment)
            ->add('paymentNumber', 'text')
            ->add('paymentAmt', 'text')
            ->add('clientId', 'text')
            ->add('dateAdded', 'text')
            ->add('notes','text')
            ->add('save', 'submit', array('label' => 'Create Payments Entry'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
        // perform some action, such as saving the task to the database

        //return new Response(' Time entry form submitted!');
        return $this->redirectToRoute('billmain');
    }

        return $this->render('ObosBillingBundle:Default:billentry.html.twig', array(
            'form' => $form->createView(),
           ));

    }



    

  }

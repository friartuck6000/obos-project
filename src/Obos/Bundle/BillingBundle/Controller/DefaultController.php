<?php

namespace Obos\Bundle\BillingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\BillEntry;


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


     //The following is a test mthod inserted by Symfony. Do not remove.
    /**
     * @Route("/bill/entry")
     * @Template()
     */
    public function myAction(Request $request)
    {
    
        $bentry = new BillEntry();
        $bentry->setclientName('PriceWaterHouse');
        $bentry->setBillingHours('99');
        $bentry->setDate('November 24');

        $form = $this->createFormBuilder($bentry)
            ->add('clientName', 'text')
            ->add('date', 'text')
            ->add('billingHours', 'text')
            ->add('save', 'submit', array('label' => 'Create Billing Entry'))
            ->getForm();

        return $this->render('ObosBillingBundle:Default:billing.html.twig', array(
            'form' => $form->createView(),
            ));
         //return $this->render(
           // 'ObosBillingBundle:Default:billing.html.twig');
    }




    

  }

<?php

namespace Obos\Bundle\TimekeepingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Timestamp;
use AppBundle\Entity\TimeKeepingReport;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }

    /**
     * @Route("/tk/timemain", name="timemain")
     * @Template()
     */
    public function timeMainAction(Request $request)
    {
        
        return $this->render('ObosTimekeepingBundle:Default:timekeeping.html.twig');

    }

    /**
     * @Route("/tester", name="tester")
     * @Template()
     */
    public function successAction()
    {
        return new Response('Form submitted!:)');
    }


    /**
     * @Route("/tk/timeentry", name="timeentry")
     * @Template()
     */
    public function clockInAction(Request $request)
    {
        $timestamp = new Timestamp();

        $form = $this->createFormBuilder($timestamp)
            ->add('workStart', 'text')
            ->add('workStop', 'text')
            ->add('clientId', 'text')
            ->add('userId', 'text')
            ->add('description','text')
            ->add('save', 'submit', array('label' => 'Create Time Entry'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
        // perform some action, such as saving the task to the database

        //return new Response(' Time entry form submitted!');
        return $this->redirectToRoute('timemain');
    }

        return $this->render('ObosTimekeepingBundle:Default:timeentry.html.twig', array(
            'form' => $form->createView(),
           ));

    }


    /**
     * @Route("/tk/timedelete")
     * @Template()
     */
    public function deleteTimeAction(Request $request)
    {
        $timestamp = new Timestamp();

        $form = $this->createFormBuilder($timestamp)
            ->add('workStart', 'text')
            ->add('clientId', 'text')
            ->add('userId', 'text')
            ->add('save', 'submit', array('label' => 'Delete Time Entry'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
        // perform some action, such as saving the task to the database

        //return new Response('Delete entry form submitted!');
        return $this->redirectToRoute('timemain');
    }

        return $this->render('ObosTimekeepingBundle:Default:timeentrydelete.html.twig', array(
            'form' => $form->createView(),
           ));

    }


      /**
     * @Route("/tk/timeedit")
     * @Template()
     */
    public function editTimeAction(Request $request)
    {
        $timestamp = new Timestamp();

        $form = $this->createFormBuilder($timestamp)
            ->add('workStart', 'text')
            ->add('clientId', 'text')
            ->add('userId', 'text')
            ->add('save', 'submit', array('label' => 'Edit Time Entry'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
        // perform some action, such as saving the task to the database

        //return new Response('Time entry edit form submitted!');
        return $this->redirectToRoute('timemain');
    }

        return $this->render('ObosTimekeepingBundle:Default:timeentryedit.html.twig', array(
            'form' => $form->createView(),
           ));

    }


      /**
     * @Route("/tk/timereport")
     * @Template()
     */
    public function reportTimeAction(Request $request)
    {
        $timereport = new TimeKeepingReport();

        $form = $this->createFormBuilder($timereport)
            ->add('userID', 'text')
            ->add('fromdate', 'text')
            ->add('todate', 'text')
            ->add('save', 'submit', array('label' => 'Compile Report'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
        // perform some action, such as saving the task to the database

        //return new Response('Timekeeping report request submitted!');
        return $this->redirectToRoute('timemain');
    }

        return $this->render('ObosTimekeepingBundle:Default:timekeepingreport.html.twig', array(
            'form' => $form->createView(),
           ));

    }


    
   
}

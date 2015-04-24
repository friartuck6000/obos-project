<?php

namespace Obos\Bundle\TimekeepingBundle\Controller;

use Obos\Bundle\CoreBundle\Entity\Project;
use Obos\Bundle\CoreBundle\Entity\Timestamp;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/timeclock")
 */
class TimestampController extends Controller
{
    /**
     * @return  Response
     *
     * @Route("/", name="timeclock.root")
     */
    public function indexAction()
    {
        $manager = $this->get('obos.manager.timestamp');
        $timestamps = $manager->getAllUserTimestamps();
        $openTimestamp = $manager->getOpenTimestamp();

        return $this->render('timeclock/index.html.twig', [
            'timestamps' => $timestamps,
            'openTimestamp' => $openTimestamp
        ]);
    }

    /**
     * @param   Project  $project
     * @return  Response
     *
     * @Route("/in/{project}", name="timeclock.in")
     */
    public function punchInAction(Project $project)
    {
        $this->get('obos.manager.timestamp')->punchIn($project);

        return $this->redirectToRoute('projects.single_view', [
            'project' => $project->getId()
        ]);
    }

    /**
     * @param   Project  $project
     * @return  Response
     *
     * @Route("/out/{project}", name="timeclock.out")
     */
    public function punchOutAction(Project $project = null)
    {
        $this->get('obos.manager.timestamp')->punchOut();

        // If a project was passed in, redirect to it; otherwise, redirect to the
        // project listing page
        if ($project) {
            return $this->redirectToRoute('projects.single_view', [
                'project' => $project->getId()
            ]);
        } else {
            return $this->redirectToRoute('projects.root');
        }
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param   Request  $request
     * @return  Response
     *
     * @Route("/new", name="timeclock.new_stamp")
     */
    public function createTimestampAction(Request $request)
    {
        // Get timestamp manager
        $manager = $this->get('obos.manager.timestamp');

        $timestamp = new Timestamp();
        $form = $this->createForm('timestamp', $timestamp);

        return $this->render('timeclock/addTimestamp.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

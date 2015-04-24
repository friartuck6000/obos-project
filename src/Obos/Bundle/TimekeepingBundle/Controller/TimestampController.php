<?php

namespace Obos\Bundle\TimekeepingBundle\Controller;

use Obos\Bundle\CoreBundle\Entity\Project;
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
     * @param   Request  $request
     * @param   Project  $project
     * @return  Response
     *
     * @Route("/in/{project}", name="timeclock.in")
     */
    public function punchInAction(Request $request, Project $project)
    {
        $this->get('obos.manager.timestamp')->punchIn($project);

        return $this->redirectToRoute('projects.single_view', [
            'project' => $project->getId()
        ]);
    }

    /**
     * @param   Request  $request
     * @param   Project  $project
     * @return  Response
     *
     * @Route("/out/{project}", name="timeclock.out")
     */
    public function punchOutAction(Request $request, Project $project = null)
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
}

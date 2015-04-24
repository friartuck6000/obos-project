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
    public function punchInAction(Request $request, Project $project)
    {}

    public function punchOutAction(Request $request)
    {}
}

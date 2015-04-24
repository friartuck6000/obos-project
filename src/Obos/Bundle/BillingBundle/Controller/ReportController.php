<?php

namespace Obos\Bundle\BillingBundle\Controller;

use Obos\Bundle\CoreBundle\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/billing")
 */
class ReportController extends Controller
{
    /**
     * @return  Response
     *
     * @Route("/", name="billing.root")
     */
    public function indexAction()
    {
        $projectManager = $this->get('obos.manager.project');

        /** @var  Project[]  $projects */
        $projects = $projectManager->getProjectListBuilder()
            ->addSelect(['c', 'i', 't'])
            ->leftJoin('p.client', 'c')
            ->leftJoin('p.invoices', 'i')
            ->leftJoin('p.timestamps', 't')
            ->leftJoin('i.payments', 'ip')
            ->getQuery()->getResult();

        return $this->render('billing/index.html.twig', [
            'projects' => $projects
        ]);
    }
}

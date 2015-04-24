<?php

namespace Obos\Bundle\BillingBundle\Controller;

use Obos\Bundle\CoreBundle\Entity\Invoice;
use Obos\Bundle\CoreBundle\Entity\Project;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/billing/invoices")
 */
class InvoiceController extends Controller
{
    /**
     * @param   Request  $request
     * @param   Project  $project
     * @return  Response
     *
     * @Route("/generate/{project}", name="invoices.generate")
     */
    public function generateInvoiceAction(Request $request, Project $project)
    {
        $manager = $this->get('obos.manager.invoice');

        $invoice = new Invoice();
        $invoice->setProject($project)
            ->setDateDue(new \DateTime('now + 30 days'));
        $form = $this->createForm('invoice', $invoice);

        $form->handleRequest($request);

        return $this->render('billing/invoice/addInvoice.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

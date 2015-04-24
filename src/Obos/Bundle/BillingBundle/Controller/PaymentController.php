<?php

namespace Obos\Bundle\BillingBundle\Controller;

use Obos\Bundle\CoreBundle\Entity\Payment;
use Obos\Bundle\CoreBundle\Entity\Project;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/billing/payments")
 */
class PaymentController extends Controller
{
    /**
     * @param   Request  $request
     * @param   Project  $project
     * @return  Response
     *
     * @Route("/add/{project}", name="payments.add")
     */
    public function createPaymentAction(Request $request, Project $project)
    {
        $manager = $this->get('obos.manager.payment');

        $latestOpenInvoice = $project->getUnpaidInvoices()->first();

        $payment = new Payment();
        $payment->setInvoice($latestOpenInvoice)
            ->setDatePaid(new \DateTime());

        $form = $this->createForm('payment', $payment);

        $form->handleRequest($request);
        if ($form->isValid()) {

            if ($manager->savePayment($payment, $form)) {
                return $this->redirectToRoute('billing.root');
            }
        }

        return $this->render('billing/payment/addPayment.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

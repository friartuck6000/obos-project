<?php

namespace Obos\Bundle\BillingBundle\Manager;

use Obos\Bundle\CoreBundle\Entity\Invoice;
use Obos\Bundle\CoreBundle\Entity\Payment;
use Obos\Bundle\CoreBundle\Entity\Timestamp;
use Obos\Bundle\CoreBundle\Manager\AbstractPersistenceManager;
use Obos\Bundle\CoreBundle\Manager\UserDependentTrait;
use Symfony\Component\Form\Form;


class PaymentManager extends AbstractPersistenceManager
{
    use UserDependentTrait;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param   Payment  $payment
     * @param   Form     $form
     * @return  bool
     */
    public function savePayment(Payment $payment, Form $form)
    {
        // Validate user association
        if (!$this->userMatches($form->get('consultantID'))) {

            $this->addFlash('danger', 'The payment could not be saved.');

            return false;
        }

        $invoice = $payment->getInvoice()->update();
        $invoice->addPayment($payment)
            ->refreshAmountDue();

        $project = $invoice->getProject()->update();

        try {
            $this->entityManager->persist($project);
            $this->entityManager->persist($invoice);
            $this->entityManager->persist($payment);
            $this->entityManager->flush();
        } catch (\Exception $e) {

            $this->addFlash('danger', 'The payment could not be saved because of a database error.');

            return false;
        }

        $this->addFlash('success', sprintf(
            'The payment for the <i>%s</i> project was saved successfully.',
            $project->getTitle()
        ));

        return true;
    }

    /**
     * @param   Payment  $payment
     * @return  bool
     */
    public function deletePayment(Payment $payment)
    {
        $invoice = $payment->getInvoice()->update();
        $invoice->removePayment($payment)
            ->refreshAmountDue();
        
        $project = $invoice->getProject()->update();

        if ($this->entityManager->contains($payment)) {

            try {
                $this->entityManager->persist($invoice);
                $this->entityManager->persist($project);
                $this->entityManager->remove($payment);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('danger', 'The payment could not be removed because of a database error.');

                return false;
            }
        }

        $this->addFlash('success', sprintf(
            'The payment for the <i>%s</i> project was removed successfully.',
            $project->getTitle()
        ));

        return true;
    }

    /**
     * @param   Payment  $payment
     * @param   Form     $form
     * @return  bool
     */
    public function saveOrDeletePayment(Payment $payment, Form $form)
    {
        $action = $form->getClickedButton();
        if ($action) {
            if ($action->getName() == 'delete') {
                return $this->deletePayment($payment);
            } else {
                return $this->savePayment($payment, $form);
            }
        }

        return false;
    }
}

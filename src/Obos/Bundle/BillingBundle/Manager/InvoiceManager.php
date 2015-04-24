<?php

namespace Obos\Bundle\BillingBundle\Manager;

use Obos\Bundle\CoreBundle\Entity\Invoice;
use Obos\Bundle\CoreBundle\Manager\AbstractPersistenceManager;
use Obos\Bundle\CoreBundle\Manager\UserDependentTrait;
use Symfony\Component\Form\Form;


class InvoiceManager extends AbstractPersistenceManager
{
    use UserDependentTrait;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param   Invoice  $invoice
     * @param   Form     $form
     * @return  bool
     */
    public function saveInvoice(Invoice $invoice, Form $form)
    {
        // Validate user association
        if (!$this->userMatches($form->get('consultantID'))) {

            $this->addFlash('danger', 'The invoice could not be saved.');

            return false;
        }

        $invoice->update();
        $project = $invoice->getProject()->update();

        try {
            $this->entityManager->persist($project);
            $this->entityManager->persist($invoice);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            $this->addFlash('danger', 'The invoice could not be saved because of a database error.');

            return false;
        }

        $this->addFlash('success', sprintf(
            'The invoice for the <i>%s</i> project was saved successfully.',
            $project->getTitle()
        ));

        return true;
    }

    /**
     * @param   Invoice  $invoice
     * @return  bool
     */
    public function deleteInvoice(Invoice $invoice)
    {
        $project = $invoice->getProject()->update();
        
        if ($this->entityManager->contains($invoice)) {


            try {
                $this->entityManager->persist($project);
                $this->entityManager->remove($invoice);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('danger', 'The invoice could not be removed because of a database error.');

                return false;
            }
        }

        $this->addFlash('success', sprintf(
            'The invoice for the <i>%s</i> project was removed successfully.',
            $project->getTitle()
        ));

        return true;
    }

    /**
     * @param   Invoice  $invoice
     * @param   Form     $form
     * @return  bool
     */
    public function saveOrDeleteInvoice(Invoice $invoice, Form $form)
    {
        $action = $form->getClickedButton();
        if ($action) {
            if ($action->getName() == 'delete') {
                return $this->deleteInvoice($invoice);
            } else {
                return $this->saveInvoice($invoice, $form);
            }
        }

        return false;
    }
}

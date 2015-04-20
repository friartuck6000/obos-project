<?php

namespace Obos\Bundle\BillingBundle\Manager;

use Obos\Bundle\CoreBundle\Manager,
    Obos\Bundle\CoreBundle\Entity\Project,
    Obos\Bundle\CoreBundle\Entity\Invoice,
    Obos\Bundle\CoreBundle\Entity\Timestamp,
    DateTime,
    DateInterval;


class BillingManager extends Manager\AbstractPersistenceManager
{
    use Manager\UserDependentTrait;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  Project[]  A list of projects with billable hours.
     */
    protected $billableProjects;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Get a list of billable projects. Reuses {@see $billableProjects} if it is set.
     *
     * @return  Project[]
     */
    public function getBillableProjects()
    {
        if ($this->billableProjects)
        {
            return $this->billableProjects;
        }

        // Build the query, pre-joining timestamp listings
        $qb = $this->entityManager->createQueryBuilder()
            ->select(['p', 't'])
            ->from('ObosCoreBundle:Project', 'p')
            ->join('p.timestamps', 't')
            ->where('p.consultant = ?1')
            ->setParameter(1, $this->user);
        $projects = $qb->getQuery()->getResult();

        return ($this->billableProjects = $projects);
    }

    /**
     * Calculate billable hours.
     *
     * @return  DateInterval
     */
    public function getBillableHours()
    {
        // Get the billable project list
        $projects = $this->getBillableProjects();

        $start = new DateTime();
        $end = clone $start;

        /** @var  Project  $project */
        foreach ($projects as $project)
        {
            $end->add($project->getLoggedTime(TRUE));
        }

        return $start->diff($end, TRUE);
    }

    public function createInvoice(Project $project)
    {
        $invoice = new Invoice();

        // Set the due date to 30 days from now
        $dateDue = new DateTime();
        $dateDue->add(new DateInterval('P30D'));

        // Calculate the amount to bill.
        $billableHours = $project->getLoggedTime(TRUE);
        $zero = new DateTime();
        $seconds = $zero->add($billableHours)->getTimestamp();
        $amountToBill = ($seconds / 3600 * $project->getHourlyRate());

        // Build the invoice data
        $invoice->setProject($project)
            ->setDateDue($dateDue)
            ->setAmountBilled($amountToBill)
            ->setAmountDue($amountToBill)
            ->update();

        // Persist the new invoice
        $this->entityManager->persist($invoice);

        // Claim all of the timestamps we just billed for.
        /** @var  Timestamp  $timestamp */
        foreach ($project->getBillableTimestamps() as $timestamp)
        {
            $timestamp->setInvoice($invoice);
            $this->entityManager->persist($timestamp);
        }

        // Run a transaction to save all changes
        $this->entityManager->flush();

        return $invoice;
    }
}

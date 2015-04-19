<?php

namespace Obos\Bundle\BillingBundle\Manager;

use Obos\Bundle\CoreBundle\Manager,
    Obos\Bundle\CoreBundle\Entity\Project,
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
}

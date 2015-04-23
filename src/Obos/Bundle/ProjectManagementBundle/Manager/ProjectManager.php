<?php

namespace Obos\Bundle\ProjectManagementBundle\Manager;

use Obos\Bundle\CoreBundle\Manager\AbstractPersistenceManager;
use Obos\Bundle\CoreBundle\Manager\UserDependentTrait;
use Doctrine\ORM\QueryBuilder;


/**
 * Persistence manager for Projects.
 */
class ProjectManager extends AbstractPersistenceManager
{
    use UserDependentTrait;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Generate a QueryBuilder instance that loads projects for the current user.
     *
     * @return  QueryBuilder
     */
    public function getProjectListBuilder()
    {
        $builder = $this->entityManager->createQueryBuilder()
            ->select('p')
            ->from('ObosCoreBundle:Project', 'p')
            ->where('p.consultant = ?1')
            ->setParameter(1, $this->user);

        return $builder;
    }

    // -----------------------------------------------------------------------------------------------------------------
}
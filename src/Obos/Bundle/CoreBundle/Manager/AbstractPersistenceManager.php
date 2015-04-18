<?php

namespace Obos\Bundle\CoreBundle\Manager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface,
    Doctrine\Common\Persistence\ManagerRegistry,
    Doctrine\ORM\EntityManagerInterface,
    Obos\Bundle\CoreBundle\Exception\InvalidConfigurationException;


/**
 * Abstract base for persistence management services.
 *
 */
abstract class AbstractPersistenceManager
{
    /**
     * @var  EntityManagerInterface  The entity manager to use for persistence operations.
     */
    protected $entityManager;

    /**
     * Build the service. Subclasses using additional dependencies must either:
     *
     *  1. Override this constructor, being sure to call parent::__construct() with the
     *     required parameters; or
     *
     *  2. Leave the constructor as is and use method calls to set additional
     *     dependency references.
     *
     * @param  ManagerRegistry  $managerRegistry
     * @param  string           $entityName
     */
    public function __construct(
        ManagerRegistry $managerRegistry,
        $entityName
    )
    {
        // Attempt to load the manager for the given entity. If one can't be loaded,
        // we have a serious problem.
        $this->entityManager = $managerRegistry->getManagerForClass('ObosCoreBundle:'. $entityName);
        if (!$this->entityManager)
        {
            throw new InvalidConfigurationException(sprintf(
                'There is no entity manager configured for the %s entity.',
                $entityName
            ));
        }
    }
}
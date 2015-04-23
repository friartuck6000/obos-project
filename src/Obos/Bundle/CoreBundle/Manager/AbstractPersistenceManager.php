<?php

namespace Obos\Bundle\CoreBundle\Manager;

use Symfony\Component\HttpFoundation\Request;
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
     * @var  Request  A request object.
     */
    protected $request;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Build the service. Subclasses using additional dependencies must either:
     *
     *  1. Override this constructor, being sure to call parent::__construct() with the
     *     required parameters; or
     *
     *  2. Leave the constructor as is and use method calls to set additional
     *     dependency references.
     *
     * @param  Request          $request
     * @param  ManagerRegistry  $managerRegistry
     * @param  string           $entityName
     */
    public function __construct(
        Request $request,
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

        // Set the request reference
        $this->request = $request;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Adds a flash message to the current session for type.
     *
     * @param string $type    The type
     * @param string $message The message
     *
     * @throws \LogicException
     */
    protected function addFlash($type, $message)
    {
        if (!$this->request->hasSession()) {
            throw new \LogicException('You can not use the addFlash method if sessions are disabled.');
        }

        $this->request->getSession()->getFlashBag()->add($type, $message);
    }

}

<?php

namespace Obos\Bundle\CoreBundle\Manager;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface,
    Obos\Bundle\CoreBundle\Entity\Consultant,
    Obos\Bundle\CoreBundle\Exception\InvalidArgumentException;


/**
 * Defines a dependency for user-specific persistence managers.
 */
trait UserDependentTrait
{
    /**
     * @var  Consultant  The user.
     */
    protected $user;

    public function setUser(TokenStorageInterface $tokenStorage)
    {
        $this->user = $tokenStorage->getToken()->getUser();
        if (!($this->user instanceof Consultant))
        {
            throw new InvalidArgumentException('User must be a valid Consultant.');
        }
    }

    /**
     * Check whether the user ID passed in from a form matches the current user.
     *
     * @param   FormInterface  $idField
     * @return  bool
     */
    public function userMatches(FormInterface $idField)
    {
        return ($idField->getData() == $this->user->getId());
    }
}

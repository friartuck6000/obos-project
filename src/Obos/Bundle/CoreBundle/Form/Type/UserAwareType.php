<?php

namespace Obos\Bundle\CoreBundle\Form\Type;

use Obos\Bundle\CoreBundle\Entity\Consultant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


/**
 * Template for user-aware forms.
 *
 */
abstract class UserAwareType extends AbstractType
{
    /**
     * @var  Consultant  The user.
     */
    protected $user;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->user = $tokenStorage->getToken()->getUser();
    }
}

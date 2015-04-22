<?php

namespace Obos\Bundle\CoreBundle\Form\Type;

use Obos\Bundle\CoreBundle\Entity\Consultant;
use Symfony\Component\Form\AbstractType;


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

    public function __construct(Consultant $user)
    {
        $this->user = $user;
    }
}

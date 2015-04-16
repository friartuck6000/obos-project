<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * The base user entity. See the Consultant and Administrator entities for specific
 * implementations.
 *
 * @ORM\Entity()
 * @ORM\Table(name="users")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="role", type="string", length=24)
 * @ORM\DiscriminatorMap({
 *     "ROLE_ADMINISTRATOR" = "Administrator",
 *     "ROLE_CONSULTANT"    = "Consultant"
 * })
 */
class User
{
    use Template\IdentifierTrait;

    // -----------------------------------------------------------------------------------------------------------------
}

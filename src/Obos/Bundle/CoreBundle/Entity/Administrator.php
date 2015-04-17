<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * The Administrator user; descendant of {@see User}.
 *
 * @ORM\Entity()
 */
class Administrator extends User
{}

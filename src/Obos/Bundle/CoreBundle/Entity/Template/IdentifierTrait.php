<?php

namespace Obos\Bundle\CoreBundle\Entity\Template;

use Doctrine\ORM\Mapping as ORM;


/**
 * Implements the ID field; because who really wants to write this over and over.
 *
 */
trait IdentifierTrait
{
    /**
     * @var  int  The entity's ID.
     *
     * @ORM\Column(name="ID", type="integer", nullable=FALSE)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @return  int
     */
    public function getId()
    {
        return $this->id;
    }
}

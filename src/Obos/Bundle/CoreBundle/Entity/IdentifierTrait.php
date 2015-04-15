<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 4/15/15
 * Time: 3:31 AM
 */

namespace Obos\Bundle\CoreBundle\Entity;


/**
 * Used by all entities; implements the {@see getId()} method so it doesn't have to be
 * rewritten on every single entity.
 *
 */
trait IdentifierTrait {

    /**
     * @return  int  The object's ID.
     */
    public function getId()
    {
        return $this->id;
    }
}

<?php

namespace Obos\Bundle\CoreBundle\Entity\Template;

use Doctrine\Common\Collections\ArrayCollection;


/**
 * Implements a metadata retrieval method for entities that have metadata attached.
 *
 * NOTE: Entities using this trait MUST implement their own mapped collection field,
 * which MUST be named $meta. This is due to an inheritance mapping issue with Doctrine.
 *
 */
trait MetaAttachedTrait
{
    /**
     * Get metadata.
     *
     * The return collection can optionally be filtered by a specific key. Furthermore,
     * if $single is set and there is more than one field with the same key, only the
     * most recent field will be returned.
     *
     * @param   string  $key
     * @param   bool    $single
     * @return  ArrayCollection|MetaField
     */
    public function getMeta($key = NULL, $single = FALSE)
    {
        /** @var  ArrayCollection  $meta */
        $meta = $this->meta;

        // If no key was given, return the entire collection.
        if (!$key)
        {
            return $meta;
        }

        // Otherwise filter the return collection.
        $filtered = $meta->filter(function(MetaField $field) use ($key)
        {
            return ($field->getKey() === $key);
        });

        // If single was supplied, return only the most recent field; otherwise return
        // the whole filtered collection
        return ($single) ? $filtered->last() : $filtered;
    }
}

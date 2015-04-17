<?php

namespace Obos\Bundle\CoreBundle\Entity\Template;

use Doctrine\ORM\Mapping as ORM;


/**
 * Abstract template for a key/value meta field.
 */
abstract class MetaField
{
    use IdentifierTrait;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  string  The metadata key.
     *
     * @ORM\Column(type="string", length=96, nullable=FALSE)
     */
    protected $key;

    /**
     * @var  mixed  The metadata value. If the value is an object or array, it will be serialized
     *              when set and unserialized when retrieved.
     *
     * @ORM\Column(type="text", nullable=TRUE)
     */
    protected $value;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param   string  $key
     * @return  $this
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @param   mixed  $value
     * @return  $this
     */
    public function setValue($value)
    {
        // Serialize $value if it is an object or array
        $this->value = (is_array($value) || is_object($value)) ? @serialize($value) : $value;

        return $this;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @return  string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return  mixed
     */
    public function getValue()
    {
        // If the value is serialized, unserialize and return it
        if ($this->value !== FALSE && ($unserialized = @unserialize($this->value)) !== FALSE)
        {
            return $unserialized;
        }

        // Otherwise return the raw value
        return $this->value;
    }
}

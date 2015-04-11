<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity()
 */
class Consultant extends User {

    /**
     * @var  string
     *
     * @ORM\Column(type="string", length=32, nullable=TRUE)
     */
    protected $title;

    /**
     * @var  string
     *
     * @ORM\Column(type="string", length=32, nullable=TRUE)
     */
    protected $industry;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param   string  $title
     * @return  $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
    /**
     * @return  string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param   string  $industry
     * @return  $this
     */
    public function setIndustry($industry)
    {
        $this->industry = $industry;
        return $this;
    }
    /**
     * @return  string
     */
    public function getIndustry()
    {
        return $this->industry;
    }
}

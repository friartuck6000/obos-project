<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Symfony\Component\Validator\Constraints as Assert;


/**
 * The actual application user; extends the base {@see User} entity class. This entity extension
 * primarily includes personalization data like professional title, industry, etc.
 *
 * @ORM\Entity()
 */
class Consultant extends User {

    /**
     * @var  string  The Consultant's job title.
     *
     * @ORM\Column(type="string", length=32, nullable=TRUE)
     */
    protected $title;

    /**
     * @var  string  The industry the Consultant primarily operates in.
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
     * @param   string  $industry
     * @return  $this
     */
    public function setIndustry($industry)
    {
        $this->industry = $industry;
        return $this;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @return  string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return  string
     */
    public function getIndustry()
    {
        return $this->industry;
    }
}

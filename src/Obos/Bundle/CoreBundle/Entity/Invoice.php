<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection;


/**
 * A bill for work performed on a project.
 *
 * @ORM\Entity()
 * @ORM\Table(name="invoices", indexes={
 *     @ORM\Index(columns={"paid"})
 * })
 */
class Invoice
{
    use Template\IdentifierTrait,
        Template\ModifiableTrait,
        Template\DeliverableTrait,
        Template\MetaAttachedTrait;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  Project  The project this invoices is associated with.
     *
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="projectID", referencedColumnName="ID", onDelete="CASCADE")
     */
    protected $project;

    /**
     * @var  string  The original amount billed.
     *
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=FALSE)
     */
    protected $amountBilled = '0.00';

    /**
     * @var  string  The remaining amount due; an invoice may be paid in multiple payments, so this field allows
     *               us to track the outstanding balance.
     *
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=FALSE)
     */
    protected $amountDue = '0.00';

    /**
     * @var  bool  Flag indicating whether the invoice has been paid in full.
     *
     * @ORM\Column(type="boolean", nullable=FALSE)
     */
    protected $paid = FALSE;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  ArrayCollection  A collection of timestamps that this invoice is billing against.
     *
     * @ORM\OneToMany(targetEntity="Timestamp", mappedBy="invoice")
     * @ORM\OrderBy({
     *     "startStamp" = "DESC"
     * })
     */
    protected $timestamps;

    /**
     * @var  ArrayCollection  A collection of all the payments against this invoice.
     *
     * @ORM\OneToMany(targetEntity="Payment", mappedBy="invoice")
     * @ORM\OrderBy({
     *     "datePaid" = "DESC"
     * })
     */
    protected $payments;

    /**
     * @var  ArrayCollection The metadata attached to this invoice.
     *
     * @ORM\OneToMany(targetEntity="InvoiceMetaField", mappedBy="invoice")
     */
    protected $meta;

    /**
     * Constructor; required for initializing collections.
     *
     */
    public function __construct()
    {
        $this->timestamps = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->meta = new ArrayCollection();
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param   Project $project
     * @return  $this
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @param   string $amountBilled
     * @return  $this
     */
    public function setAmountBilled($amountBilled)
    {
        $this->amountBilled = $amountBilled;

        return $this;
    }

    /**
     * @param   string $amountDue
     * @return  $this
     */
    public function setAmountDue($amountDue)
    {
        $this->amountDue = $amountDue;

        return $this;
    }

    /**
     * @param   boolean $paid
     * @return  $this
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;

        return $this;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @return  Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @return  string
     */
    public function getAmountBilled()
    {
        return $this->amountBilled;
    }

    /**
     * @return  string
     */
    public function getAmountDue()
    {
        return $this->amountDue;
    }

    /**
     * @return  boolean
     */
    public function isPaid()
    {
        if ($this->paid)
        {
            return $this->paid;
        }

        // If property is FALSE, recalculate it
        return ($this->paid = ((float) $this->amountDue < 0.01));
    }

    /**
     * Get the full list of linked timestamps.
     *
     * @return  ArrayCollection
     */
    public function getTimestamps()
    {
        return $this->timestamps;
    }

    /**
     * Determine whether an open timestamp has been claimed by this invoice. if one is found,
     * return it (presumably so it can be released from the invoice).
     *
     * @return  Timestamp|NULL
     */
    public function getOpenTimestamp()
    {
        $first = $this->timestamps->first();
        if ($first instanceof Timestamp && $first->isOpen())
        {
            return $first;
        }

        return NULL;
    }

    /**
     * Get the full list of associated payments.
     *
     * @return  ArrayCollection
     */
    public function getPayments()
    {
        return $this->payments;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Refresh the {@see $amountDue} property by subtracting all recorded payments from the
     * original {@see $amountBilled}.
     *
     * @return  string
     */
    public function refreshAmountDue()
    {
        // Initialize the new amount
        $newAmountDue = (float) $this->amountBilled;

        /** @var  $payment  Payment */
        foreach ($this->payments as $payment)
        {
            // Subtract each payment amount; when all payments have been accounted for,
            // the value of $newAmountDue will reflect the balance
            $newAmountDue -= (float) $payment->getAmountPaid();
        }

        // We could throw this directly into a return statement, but by setting the property
        // beforehand, we can update the paid flag before returning.
        $this->amountDue = number_format($newAmountDue, 2, '.', '');
        $this->isPaid();

        return $this->amountDue;
    }
}

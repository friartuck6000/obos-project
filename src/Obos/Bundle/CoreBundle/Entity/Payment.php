<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    DateTime;


/**
 * Payment against an invoice.
 *
 * @ORM\Entity()
 * @ORM\Table(name="payments")
 */
class Payment
{
    use Template\IdentifierTrait;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var  Invoice  The invoice this payment is to be recorded against.
     *
     * @ORM\ManyToOne(targetEntity="Invoice")
     * @ORM\JoinColumn(name="invoiceID", referencedColumnName="ID", onDelete="CASCADE")
     */
    protected $invoice;

    /**
     * @var  DateTime  The date this payment was recorded.
     *
     * @ORM\Column(type="datetime", nullable=FALSE)
     */
    protected $datePaid;

    /**
     * @var  string  The amount of the payment.
     *
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=FALSE)
     */
    protected $amountPaid;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param   Invoice $invoice
     * @return  $this
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * @param   DateTime $datePaid
     * @return  $this
     */
    public function setDatePaid($datePaid)
    {
        $this->datePaid = $datePaid;

        return $this;
    }

    /**
     * @param   string $amountPaid
     * @return  $this
     */
    public function setAmountPaid($amountPaid)
    {
        $this->amountPaid = $amountPaid;

        return $this;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @return  Invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * @return  DateTime
     */
    public function getDatePaid()
    {
        return $this->datePaid;
    }

    /**
     * @return  string
     */
    public function getAmountPaid()
    {
        return $this->amountPaid;
    }
}

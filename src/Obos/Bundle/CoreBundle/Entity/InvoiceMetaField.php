<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * A field of metadata about an invoice.
 *
 * @ORM\Entity()
 * @ORM\Table(name="invoice_meta")
 */
class InvoiceMetaField extends Template\MetaField
{
    /**
     * @var  Invoice  The invoice this field is attached to.
     *
     * @ORM\ManyToOne(targetEntity="Invoice", inversedBy="meta")
     * @ORM\JoinColumn(name="invoiceID", referencedColumnName="ID", onDelete="CASCADE")
     */
    protected $invoice;

    /**
     * @param   Invoice  $invoice
     * @return  $this
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * @return  Invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }
}

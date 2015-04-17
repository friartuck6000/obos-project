<?php

namespace Obos\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * A field of metadata about a payment.
 *
 * @ORM\Entity()
 * @ORM\Table(name="payment_meta")
 */
class PaymentMetaField extends Template\MetaField
{
    /**
     * @var  Payment  The payment this field is attached to.
     *
     * @ORM\ManyToOne(targetEntity="Payment")
     * @ORM\JoinColumn(name="paymentID", referencedColumnName="ID", onDelete="CASCADE")
     */
    protected $payment;

    /**
     * @param   Payment  $payment
     * @return  $this
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * @return  Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }

}

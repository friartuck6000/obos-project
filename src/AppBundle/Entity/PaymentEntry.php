<?php
namespace AppBundle\Entity;

class PaymentEntry
{
    protected $paymentNumber;
    protected $clientID;
    protected $dateAdded;
    protected $paymentAmt;
    protected $notes;

    public function getpaymentNumber()
    {
        return $this->paymentNumber;
    }

    public function setpaymentNumber($paymentNumber)
    {
        $this->paymentNumber = $paymentNumber;
    }

    public function getclientID()
    {
        return $this->clientID;
    }

    public function setclientID($clientID)
    {
        $this->clientID = $clientID;
    }

    public function getdateAdded()
    {
        return $this->dateAdded;
    }

    public function setdateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;
    }

     public function getpaymentAmt()
    {
        return $this->paymentAmt;
    }

    public function setpaymentAmt($paymentAmt)
    {
        $this->paymentAmt = $paymentAmt;
    }

     public function getnotes()
    {
        return $this->notes;
    }

    public function setnotes($notes)
    {
        $this->notes = $notes;
    }
}
?>
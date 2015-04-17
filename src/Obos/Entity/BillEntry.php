namespace Obos\Entity;

class BillEntry
{
    protected $clientName;
    protected $date;
    protected $billingHours;

    public function getclientName()
    {
        return $this->clientName;
    }

    public function setclientName($clientName)
    {
        $this->clientName = $clientName;
    }

    public function getdate()
    {
        return $this->date;
    }

    public function setdate($date)
    {
        $this->date = $date;
    }

    public function getbillingHours()
    {
        return $this->billingHours;
    }

    public function setbillingHours($billingHours)
    {
        $this->billingHours = $billingHours;
    }
}
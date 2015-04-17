<?php
namespace AppBundle\Entity;

class TimeKeepingReport
{
    protected $userID;
    protected $fromdate;
    protected $todate;

    public function getuserID()
    {
        return $this->userID;
    }

    public function setuserID($userID)
    {
        $this->userID = $userID;
    }

    public function gettodate()
    {
        return $this->todate;
    }

    public function settodate($todate)
    {
        $this->todate = $todate;
    }

    public function getfromdate()
    {
        return $this->fromdate;
    }

    public function setfromdate($fromdate)
    {
        $this->fromdate = $fromdate;
    }
}
?>
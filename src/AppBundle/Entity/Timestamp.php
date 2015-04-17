<?php
namespace AppBundle\Entity;

class Timestamp
{
    protected $workStart;
    protected $workStop;
    protected $currentTime;
    protected $clientId;
    protected $userId;
    protected $description;

    public function getworkStart()
    {
        return $this->workStart;
    }

    public function setworkStart($workStart)
    {
        $this->workStart = $workStart;
    }

    public function getworkStop()
    {
        return $this->workStop;
    }

    public function setworkStop($workStop)
    {
        $this->workStop = $workStop;
    }

    public function getcurrentTime()
    {
        return $this->currentTime;
    }

    public function setcurrentTime($currentTime)
    {
        $this->currentTime = $currentTime;
    }

    public function getclientId()
    {
        return $this->clientId;
    }

    public function setclientId($clientId)
    {
        $this->clientId = $clientId;
    }

    public function getuserId()
    {
        return $this->userId;
    }

    public function setuserId($userId)
    {
        $this->userId = $userId;
    }

    public function getdescription()
    {
        return $this->description;
    }

    public function setdescription($description)
    {
        $this->description = $description;
    }
}
?>
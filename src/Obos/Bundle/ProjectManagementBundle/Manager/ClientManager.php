<?php

namespace Obos\Bundle\ProjectManagementBundle\Manager;

class ClientManager
{
    protected $clients;

    public function __construct()
    {
        // For initial testing
        $this->clients = [
            [
                'id' => 1,
                'name' => 'Client 1'
            ],
            [
                'id' => 2,
                'name' => 'Client 2'
            ],
            [
                'id' => 3,
                'name' => 'Client 3'
            ]
        ];
    }
    public function getAllClients()
    {
        return $this->clients;
    }

    public function getClientById($id)
    {
        // Look for a test "client"
        foreach ($this->clients as &$client)
        {
            if ($client['id'] === $id)
            {
                return $client;
            }
        }

        return FALSE;
    }
}

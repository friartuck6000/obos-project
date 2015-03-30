<?php

namespace Obos\Bundle\ProjectManagementBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientControllerTest extends WebTestCase
{
    public function testIndex()
    {
        // Build crawler
        $client = static::createClient();
        $client->followRedirects(TRUE);
        $crawler = $client->request('GET', '/clients');

        // Check response
        $this->assertTrue(
            $client->getResponse()->isSuccessful(),
            sprintf(
                'Response should be 2XX; %s received.',
                $client->getResponse()->getStatusCode()
            )
        );
        $this->assertNotRegexp(
            '/no clients found/i',
            $client->getResponse()->getContent(),
            'At least one test client must be returned.'
        );
    }

    public function testClientDetail()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/clients/3');

        // Check response
    }
}

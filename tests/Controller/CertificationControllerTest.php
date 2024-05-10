<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CertificationControllerTest extends WebTestCase
{
    public function testGetGroundCrewMembers(): void
    {
        $client = static::createClient();
        $client->request('GET', '/certifications/list');

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testAddGroundCrewMember(): void
    {
        $client = static::createClient();

        $client->request('POST', '/certifications/add', [], [], [], json_encode([]));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertJson($client->getResponse()->getContent());

        $client->request('POST', '/certifications/add', [], [], [], json_encode([
            'name' => null,
            'validFrom' => '2024-01-01',
            'validUntil' => '2024-12-31',
        ]));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertJson($client->getResponse()->getContent());

        $client->request('POST', '/certifications/add', [], [], [], json_encode([
            'name' => 'test',
            'validFrom' => '2024-01-01',
            'validUntil' => '2024-12-31',
        ]));
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertJson($client->getResponse()->getContent());
    }
}

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
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }
        $this->assertJson($responseContent);
    }

    public function testAddGroundCrewMember(): void
    {
        $client = static::createClient();

        $payload = json_encode([]);
        if ($payload === false) {
            $this->fail('Failed to encode JSON payload.');
        }

        $client->request('POST', '/certifications/add', [], [], [], $payload);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }
        $this->assertJson($responseContent);

        $payload = json_encode([
            'name' => null,
            'validFrom' => '2024-01-01',
            'validUntil' => '2024-12-31',
        ]);
        if ($payload === false) {
            $this->fail('Failed to encode JSON payload.');
        }

        $client->request('POST', '/certifications/add', [], [], [], $payload);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }
        $this->assertJson($responseContent);

        $payload = json_encode([
            'name' => 'test',
            'validFrom' => '2024-01-01',
            'validUntil' => '2024-12-31',
        ]);
        if ($payload === false) {
            $this->fail('Failed to encode JSON payload.');
        }

        $client->request('POST', '/certifications/add', [], [], [], $payload);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }
        $this->assertJson($responseContent);
    }
}

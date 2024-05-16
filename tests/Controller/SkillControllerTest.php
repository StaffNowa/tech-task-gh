<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SkillControllerTest extends WebTestCase
{
    public function testGetSkills(): void
    {
        $client = static::createClient();
        $client->request('GET', '/skills/list');

        $this->assertResponseIsSuccessful();
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }
        $this->assertJson($responseContent);
    }

    public function testAddSkill(): void
    {
        $client = static::createClient();

        $payload = json_encode([]);
        if ($payload === false) {
            $this->fail('Failed to encode JSON payload.');
        }

        $client->request('POST', '/skills/add', [], [], [], $payload);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }
        $this->assertJson($responseContent);

        $payload = json_encode([
            'name' => 'test',
        ]);
        if ($payload === false) {
            $this->fail('Failed to encode JSON payload.');
        }

        $client->request('POST', '/skills/add', [], [], [], $payload);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }
        $this->assertJson($responseContent);
    }
}

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
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testAddSkill(): void
    {
        $client = static::createClient();

        $client->request('POST', '/skills/add', [], [], [], json_encode([]));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertJson($client->getResponse()->getContent());

        $client->request('POST', '/skills/add', [], [], [], json_encode([
            'name' => 'test',
        ]));
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertJson($client->getResponse()->getContent());
    }
}

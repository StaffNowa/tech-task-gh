<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class GroundCrewMemberControllerTest extends WebTestCase
{
    public function testGetGroundCrewMembers(): void
    {
        $client = static::createClient();
        $client->request('GET', '/ground-crew-members/list');

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testAddGroundCrewMember(): void
    {
        $client = static::createClient();

        $client->request('POST', '/ground-crew-members/add', [], [], [], json_encode([]));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertJson($client->getResponse()->getContent());

        $client->request('POST', '/ground-crew-members/add', [], [], [], json_encode([
            'name' => 'test',
        ]));
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertJson($client->getResponse()->getContent());
    }
}

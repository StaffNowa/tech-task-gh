<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends WebTestCase
{
    public function testGetTasks(): void
    {
        $client = static::createClient();
        $client->request('GET', '/tasks/list');

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testAddTask(): void
    {
        $client = static::createClient();

        $client->request('POST', '/tasks/add', [], [], [], json_encode([]));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertJson($client->getResponse()->getContent());

        $client->request('POST', '/tasks/add', [], [], [], json_encode([
            'name' => null,
            'flightId' => 1,
        ]));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertJson($client->getResponse()->getContent());

        $client->request('POST', '/tasks/add', [], [], [], json_encode([
            'name' => 'test',
            'flightId' => 1,
        ]));
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCompleteTask(): void
    {
        $client = static::createClient();

        $client->request('GET', '/tasks/complete-task/10000', [], [], [], json_encode([]));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertJson($client->getResponse()->getContent());

        $client->request('GET', '/tasks/complete-task/1', [], [], [], json_encode([]));
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertJson($client->getResponse()->getContent());
    }
}

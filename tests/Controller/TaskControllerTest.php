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
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }

        $this->assertJson($responseContent);
    }

    public function testAddTask(): void
    {
        $client = static::createClient();

        $payload = json_encode([]);
        if ($payload === false) {
            $this->fail('Failed to encode JSON payload.');
        }

        $client->request('POST', '/tasks/add', [], [], [], $payload);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }
        $this->assertJson($responseContent);

        $payload = json_encode([
            'name' => null,
            'flightId' => 1,
        ]);
        if ($payload === false) {
            $this->fail('Failed to encode JSON payload.');
        }

        $client->request('POST', '/tasks/add', [], [], [], $payload);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }
        $this->assertJson($responseContent);

        $payload = json_encode([
            'name' => 'test',
            'flightId' => 1,
        ]);
        if ($payload === false) {
            $this->fail('Failed to encode JSON payload.');
        }

        $client->request('POST', '/tasks/add', [], [], [], $payload);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }
        $this->assertJson($responseContent);
    }

    public function testCompleteTask(): void
    {
        $client = static::createClient();

        $payload = json_encode([]);
        if ($payload === false) {
            $this->fail('Failed to encode JSON payload.');
        }

        $client->request('GET', '/tasks/complete-task/10000', [], [], [], $payload);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }
        $this->assertJson($responseContent);

        $payload = json_encode([]);
        if ($payload === false) {
            $this->fail('Failed to encode JSON payload.');
        }

        $client->request('GET', '/tasks/complete-task/1', [], [], [], $payload);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }
        $this->assertJson($responseContent);
    }
}

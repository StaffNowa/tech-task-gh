<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class FlightControllerTest extends WebTestCase
{
    public function testGetFlights(): void
    {
        $client = static::createClient();
        $client->request('GET', '/flights/list');

        $this->assertResponseIsSuccessful();
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }
        $this->assertJson($responseContent);
    }

    public function testGetFlight(): void
    {
        $client = static::createClient();
        $client->request('GET', '/flights/FL123');
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }
        $this->assertJson($responseContent);

        $client->request('GET', '/flights/BT341');
        $this->assertResponseIsSuccessful();
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }
        $this->assertJson($responseContent);
    }

    public function testAddFlight(): void
    {
        $client = static::createClient();

        $payload = json_encode([]);
        if ($payload === false) {
            $this->fail('Failed to encode JSON payload.');
        }

        $client->request('POST', '/flights/add', [], [], [], $payload);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }
        $this->assertJson($responseContent);

        $payload = json_encode([
            'flightNumber' => null,
            'flightDate' => '2024-05-22',
        ]);
        if ($payload === false) {
            $this->fail('Failed to encode JSON payload.');
        }

        $client->request('POST', '/flights/add', [], [], [], $payload);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }
        $this->assertJson($responseContent);

        $payload = json_encode([
            'flightNumber' => 'BT341',
            'flightDate' => '2024-05-22',
        ]);
        if ($payload === false) {
            $this->fail('Failed to encode JSON payload.');
        }

        $client->request('POST', '/flights/add', [], [], [], $payload);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }
        $this->assertJson($responseContent);
    }

    public function testFlightArrival(): void
    {
        $client = static::createClient();

        $client->request('GET', '/flights/flight-arrival/test/2024-05-11');
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }
        $this->assertJson($responseContent);

        $client->request('GET', '/flights/flight-arrival/BT341/2024-05-11');

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $responseContent = $client->getResponse()->getContent();
        if ($responseContent === false) {
            $this->fail('Response content is false');
        }
        $this->assertJson($responseContent);
    }
}

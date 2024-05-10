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
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testGetFlight(): void
    {
        $client = static::createClient();
        $client->request('GET', '/flights/FL123');
        $this->assertResponseStatusCodeSame(
            Response::HTTP_NOT_FOUND,
            $client->getResponse()->getStatusCode()
        );
        $this->assertJson($client->getResponse()->getContent());

        $client->request('GET', '/flights/BT341');
        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testAddFlight(): void
    {
        $client = static::createClient();

        $client->request('POST', '/flights/add', [], [], [], json_encode([]));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertJson($client->getResponse()->getContent());

        $client->request('POST', '/flights/add', [], [], [], json_encode([
            'flightNumber' => null,
            'flightDate' => '2024-05-22',
        ]));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertJson($client->getResponse()->getContent());

        $client->request('POST', '/flights/add', [], [], [], json_encode([
            'flightNumber' => 'BT341',
            'flightDate' => '2024-05-22',
        ]));
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testFlightArrival(): void
    {
        $client = static::createClient();

        $client->request('GET', '/flights/flight-arrival/test/2024-05-11');
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertJson($client->getResponse()->getContent());

        $client->request('GET', '/flights/flight-arrival/BT341/2024-05-11');

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertJson($client->getResponse()->getContent());
    }
}

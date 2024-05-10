<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class FlightArrivalEvent extends Event
{
    public const NAME = 'flight.arrival';

    /**
     * @param array<string, int|string> $flightDetails
     */
    public function __construct(private readonly array $flightDetails)
    {
    }

    /**
     * @return int[]|string[]
     */
    public function getFlightDetails(): array
    {
        return $this->flightDetails;
    }
}

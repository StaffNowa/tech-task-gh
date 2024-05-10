<?php

namespace App\Tests\EventSubscriber;

use App\Event\FlightArrivalEvent;
use App\EventSubscriber\FlightArrivalSubscriber;
use PHPUnit\Framework\TestCase;

class FlightArrivalSubscriberTest extends TestCase
{
    public function testGetSubscribedEvents(): void
    {
        self::assertSame([FlightArrivalEvent::class => 'onFlightArrival'], FlightArrivalSubscriber::getSubscribedEvents());
    }
}

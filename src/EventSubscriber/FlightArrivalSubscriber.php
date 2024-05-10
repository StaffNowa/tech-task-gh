<?php

namespace App\EventSubscriber;

use App\Event\FlightArrivalEvent;
use App\Service\FlightService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FlightArrivalSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly FlightService $flightService)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FlightArrivalEvent::class => 'onFlightArrival',
        ];
    }

    public function onFlightArrival(FlightArrivalEvent $event): void
    {
        $this->flightService->onFlightArrival($event->getFlightDetails());
    }
}

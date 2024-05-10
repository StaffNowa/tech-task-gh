<?php

namespace App\Controller;

use App\Entity\Flight;
use App\Event\FlightArrivalEvent;
use App\Service\FlightService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[Route('/flights')]
class FlightController extends AbstractController
{
    public function __construct(
        private readonly FlightService $flightService,
        private readonly LoggerInterface $logger,
        private readonly EventDispatcherInterface $dispatcher,
    ) {
    }

    #[Route('/list', name: 'flights', methods: ['GET'])]
    public function getFlights(): JsonResponse
    {
        return $this->json($this->flightService->getAllFlights());
    }

    #[Route('/{flightNumber}', name: 'flight', methods: ['GET'])]
    public function getFlight(string $flightNumber): JsonResponse
    {
        $flight = $this->flightService->getFlightByFlightNumber($flightNumber);
        if (!$flight) {
            return $this->json(['error' => 'Flight not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($flight);
    }

    #[Route('/add', name: 'flight_add', methods: ['POST'])]
    public function addFlight(Request $request): JsonResponse
    {
        try {
            $flight = $this->flightService->addFlight($request->getContent());
        } catch (\InvalidArgumentException $invalidArgumentException) {
            $this->logger->error('Bad request: ' . $invalidArgumentException->getMessage());

            return $this->json(['errors' => ['Bad request']], Response::HTTP_BAD_REQUEST);
        }

        if (!$flight instanceof Flight) {
            return $this->json(['errors' => $flight], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(['message' => 'Flight created successfully'], Response::HTTP_CREATED);
    }

    #[Route('/flight-arrival/{flightNumber}/{flightDate}', name: 'flight_arrival', methods: ['GET'])]
    public function flightArrival(string $flightNumber, string $flightDate): JsonResponse
    {
        try {
            $this->dispatcher->dispatch(new FlightArrivalEvent([
                'flightNumber' => $flightNumber,
                'flightDate' => $flightDate,
            ]));
        } catch (\RuntimeException $runtimeException) {
            return $this->json(['errors' => [$runtimeException->getMessage()]], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(['message' => sprintf(
            'Flight arrival information for %s on %s has been successfully dispatched.',
            $flightNumber,
            $flightDate,
        )], Response::HTTP_CREATED);
    }
}

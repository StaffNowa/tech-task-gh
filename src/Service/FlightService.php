<?php

namespace App\Service;

use App\Entity\Flight;
use App\Entity\Task;
use App\Form\Type\FlightType;
use App\Repository\FlightRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class FlightService
{
    public function __construct(
        private readonly FlightRepository $flightRepository,
        private readonly ObjectService $objectService,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @return Flight[]
     */
    public function getAllFlights(): array
    {
        return $this->flightRepository->findAll();
    }

    public function getFlightById(int $id): ?Flight
    {
        return $this->flightRepository->find($id);
    }

    public function getFlightByFlightNumber(string $flightNumber): ?Flight
    {
        return $this->flightRepository->findOneBy(['flightNumber' => $flightNumber]);
    }

    /**
     * @return Flight|array<int, string>
     */
    public function addFlight(string $requestData): Flight|array
    {
        return $this->objectService->addObject($requestData, FlightType::class, Flight::class);
    }

    /**
     * @param array<mixed> $flightDetails
     */
    public function onFlightArrival(array $flightDetails): void
    {
        $flight = $this->flightRepository->getByFlightDetails($flightDetails);
        if (!$flight) {
            throw new \RuntimeException('Flight not found', Response::HTTP_BAD_REQUEST);
        }

        $groundCrewMembers = $flight->getGroundCrewMembers();

        foreach ($groundCrewMembers as $groundCrewMember) {
            if ($groundCrewMember->getSkills()->count() === 0) {
                continue;
            }

            $task = new Task();
            $task->setFlight($flight);
            $task->setName('Task for ' . $groundCrewMember->getName());
            $this->entityManager->persist($task);
        }
        $this->entityManager->flush();
    }
}

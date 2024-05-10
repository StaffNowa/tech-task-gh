<?php

namespace App\Repository;

use App\Entity\Flight;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Flight>
 */
class FlightRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Flight::class);
    }

    /**
     * @param array<string, string> $flightDetails
     */
    public function getByFlightDetails(array $flightDetails): ?Flight
    {
        return $this->createQueryBuilder('f')
            ->where('f.flightNumber = :flightNumber')
            ->andWhere('f.flightDate = :flightDate')
            ->setParameter('flightNumber', $flightDetails['flightNumber'])
            ->setParameter('flightDate', $flightDetails['flightDate'])
            ->getQuery()->getOneOrNullResult();
    }
}

<?php

namespace App\Serializer;

use App\Entity\Flight;
use App\Entity\Task;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class TaskNormalizer implements NormalizerInterface
{
    /**
     * @param Task               $object
     * @param array<string, int> $context
     *
     * @return array<string, int|string>
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        return [
            'id' => $object->getId(),
            'flight' => $this->normalizeFlight($object->getFlight()),
            'name' => $object->getName(),
        ];
    }

    /**
     * @param array<string, int> $context
     */
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Task;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Task::class => true,
        ];
    }

    /**
     * @return array<string, string>
     */
    private function normalizeFlight(Flight $flight): array
    {
        return [
            'flightNumber' => $flight->getFlightNumber(),
            'flightDate' => $flight->getFlightDate()->format('Y-m-d'),
        ];
    }
}

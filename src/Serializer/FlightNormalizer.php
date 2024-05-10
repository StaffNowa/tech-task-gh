<?php

namespace App\Serializer;

use App\Entity\Flight;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class FlightNormalizer implements NormalizerInterface
{
    /**
     * @param Flight             $object
     * @param array<string, int> $context
     *
     * @return array<string, int|string>
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        return [
            'id' => $object->getId(),
            'flightNumber' => $object->getFlightNumber(),
            'flightDate' => $object->getFlightDate()->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @param array<string, int> $context
     */
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Flight;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Flight::class => true,
        ];
    }
}

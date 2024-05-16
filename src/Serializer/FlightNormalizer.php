<?php

namespace App\Serializer;

use App\Entity\Flight;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class FlightNormalizer implements NormalizerInterface
{
    /**
     * @param array<string, int> $context
     *
     * @return array<string, int|string>
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
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
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Flight;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            Flight::class => true,
        ];
    }
}

<?php

namespace App\Serializer;

use App\Entity\Task;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class TaskNormalizer implements NormalizerInterface
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
            'flight' => [
                'flightNumber' => $object->getFlight()->getFlightNumber(),
                'flightDate' => $object->getFlight()->getFlightDate()->format('Y-m-d'),
            ],
            'name' => $object->getName(),
        ];
    }

    /**
     * @param array<string, int> $context
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Task;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            Task::class => true,
        ];
    }
}

<?php

namespace App\Serializer;

use App\Entity\Skill;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SkillNormalizer implements NormalizerInterface
{
    /**
     * @param Skill              $object
     * @param array<string, int> $context
     *
     * @return array<string, int|string>
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        return [
            'id' => $object->getId(),
            'name' => $object->getName(),
        ];
    }

    /**
     * @param array<string, int> $context
     */
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Skill;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Skill::class => true,
        ];
    }
}

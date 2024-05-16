<?php

namespace App\Serializer;

use App\Entity\Certification;
use App\Entity\GroundCrewMember;
use App\Entity\Skill;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class GroundCrewMemberNormalizer implements NormalizerInterface
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
            'name' => $object->getName(),
            'certifications' => $this->normalizeCertifications($object->getCertifications()),
            'skills' => $this->normalizeSkills($object->getSkills()),
        ];
    }

    /**
     * @param array<string, int> $context
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof GroundCrewMember;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            GroundCrewMember::class => true,
        ];
    }

    /**
     * @param PersistentCollection<int, Certification> $certifications
     *
     * @return array<int<0, max>, array<string, mixed>>
     */
    private function normalizeCertifications(PersistentCollection $certifications): array
    {
        $normalizedCertifications = [];

        /** @var Certification $certification */
        foreach ($certifications as $certification) {
            $normalizedCertifications[] = [
                'name' => $certification->getName(),
                'validFrom' => $certification->getValidFrom()?->format('Y-m-d'),
                'validUntil' => $certification->getValidUntil()?->format('Y-m-d'),
            ];
        }

        return $normalizedCertifications;
    }

    /**
     * @param PersistentCollection<int, Skill> $skills
     *
     * @return array<int<0, max>, array<string, mixed>>
     */
    private function normalizeSkills(PersistentCollection $skills): array
    {
        $normalizedSkills = [];

        foreach ($skills as $skill) {
            $normalizedSkills[] = [
                'name' => $skill->getName(),
            ];
        }

        return $normalizedSkills;
    }
}

<?php

namespace App\Service;

use App\Entity\Certification;
use App\Form\Type\CertitifcationType;
use App\Repository\CertificationRepository;

class CertificationService
{
    public function __construct(
        private readonly CertificationRepository $certificationRepository,
        private readonly ObjectService $objectService
    ) {
    }

    /**
     * @return Certification[]
     */
    public function getAllCertifications(): array
    {
        return $this->certificationRepository->findAll();
    }

    /**
     * @return Certification|array<int, string>
     */
    public function addCertification(string $requestData): Certification|array
    {
        return $this->objectService->addObject($requestData, CertitifcationType::class, Certification::class);
    }
}

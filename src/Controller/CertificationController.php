<?php

namespace App\Controller;

use App\Entity\Certification;
use App\Service\CertificationService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/certifications')]
class CertificationController extends AbstractController
{
    public function __construct(
        private readonly CertificationService $certificationService,
        private readonly LoggerInterface $logger,
    ) {
    }

    #[Route('/list', name: 'certification_list', methods: ['GET'])]
    public function getCertifications(): JsonResponse
    {
        return $this->json($this->certificationService->getAllCertifications());
    }

    #[Route('/add', name: 'certification_add', methods: ['POST'])]
    public function addCertification(Request $request): JsonResponse
    {
        try {
            $certification = $this->certificationService->addCertification($request->getContent());
        } catch (\InvalidArgumentException $invalidArgumentException) {
            $this->logger->error('Bad request: ' . $invalidArgumentException->getMessage());

            return $this->json(['errors' => ['Bad request']], Response::HTTP_BAD_REQUEST);
        }

        if (!$certification instanceof Certification) {
            return $this->json(['errors' => $certification], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(['message' => 'Certification created successfully'], Response::HTTP_CREATED);
    }
}

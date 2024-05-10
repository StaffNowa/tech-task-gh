<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Service\SkillService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/skills')]
class SkillController extends AbstractController
{
    public function __construct(private readonly SkillService $skillService, private readonly LoggerInterface $logger)
    {
    }

    #[Route('/list', name: 'skill_list', methods: ['GET'])]
    public function getSkills(): JsonResponse
    {
        return $this->json($this->skillService->getAllSkills());
    }

    #[Route('/add', name: 'skill_add', methods: ['POST'])]
    public function addSkill(Request $request): JsonResponse
    {
        try {
            $skill = $this->skillService->addSkill($request->getContent());
        } catch (\InvalidArgumentException $invalidArgumentException) {
            $this->logger->error('Bad request: ' . $invalidArgumentException->getMessage());

            return $this->json(['errors' => ['Bad request']], Response::HTTP_BAD_REQUEST);
        }

        if (!$skill instanceof Skill) {
            return $this->json(['errors' => $skill], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(['message' => 'Skill created successfully'], Response::HTTP_CREATED);
    }
}

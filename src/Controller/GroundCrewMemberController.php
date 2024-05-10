<?php

namespace App\Controller;

use App\Entity\GroundCrewMember;
use App\Service\GroundCrewMemberService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ground-crew-members')]
class GroundCrewMemberController extends AbstractController
{
    public function __construct(private readonly GroundCrewMemberService $groundCrewMemberService, private readonly LoggerInterface $logger)
    {
    }

    #[Route('/list', name: 'ground-crew-members', methods: ['GET'])]
    public function getGroundCrewMembers(): JsonResponse
    {
        return $this->json($this->groundCrewMemberService->getAllGroundCrewMembers());
    }

    #[Route('/add', name: 'ground-crew-members-add', methods: ['POST'])]
    public function addGroundCrewMember(Request $request): JsonResponse
    {
        try {
            $groundCrewMember = $this->groundCrewMemberService->addGroundCrewMember($request->getContent());
        } catch (\InvalidArgumentException $invalidArgumentException) {
            $this->logger->error('Bad request: ' . $invalidArgumentException->getMessage());

            return $this->json(['errors' => ['Bad request']], Response::HTTP_BAD_REQUEST);
        }

        if (!$groundCrewMember instanceof GroundCrewMember) {
            return $this->json(['errors' => $groundCrewMember], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(['message' => 'Ground crew member created successfully'], Response::HTTP_CREATED);
    }
}

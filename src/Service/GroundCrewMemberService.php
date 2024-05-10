<?php

namespace App\Service;

use App\Entity\GroundCrewMember;
use App\Form\Type\GroundCrewMemberType;
use App\Repository\GroundCrewMemberRepository;

class GroundCrewMemberService
{
    public function __construct(
        private readonly GroundCrewMemberRepository $groundCrewMemberRepository,
        private readonly ObjectService $objectService,
    ) {
    }

    /**
     * @return GroundCrewMember[]
     */
    public function getAllGroundCrewMembers(): array
    {
        return $this->groundCrewMemberRepository->findAll();
    }

    /**
     * @return GroundCrewMember|array<int, string>
     */
    public function addGroundCrewMember(string $requestData): GroundCrewMember|array
    {
        return $this->objectService->addObject($requestData, GroundCrewMemberType::class, GroundCrewMember::class);
    }
}

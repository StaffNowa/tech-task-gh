<?php

namespace App\Service;

use App\Entity\Skill;
use App\Form\Type\SkillType;
use App\Repository\SkillRepository;

class SkillService
{
    public function __construct(
        private readonly SkillRepository $skillRepository,
        private readonly ObjectService $objectService,
    ) {
    }

    /**
     * @return Skill[]
     */
    public function getAllSkills(): array
    {
        return $this->skillRepository->findAll();
    }

    /**
     * @return Skill|array<int, string>
     */
    public function addSkill(string $requestData): Skill|array
    {
        return $this->objectService->addObject($requestData, SkillType::class, Skill::class);
    }
}

<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    /**
     * @var Collection<int, GroundCrewMember>
     */
    #[ORM\ManyToMany(targetEntity: GroundCrewMember::class, mappedBy: 'skills')]
    private Collection $groundCrewMembers;

    public function __construct()
    {
        $this->groundCrewMembers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, GroundCrewMember>
     */
    public function getGroundCrewMembers(): Collection
    {
        return $this->groundCrewMembers;
    }

    public function addGroundCrewMember(GroundCrewMember $groundCrewMember): static
    {
        if (!$this->groundCrewMembers->contains($groundCrewMember)) {
            $this->groundCrewMembers->add($groundCrewMember);
            $groundCrewMember->addSkill($this);
        }

        return $this;
    }

    public function removeGroundCrewMember(GroundCrewMember $groundCrewMember): static
    {
        if ($this->groundCrewMembers->removeElement($groundCrewMember)) {
            $groundCrewMember->removeSkill($this);
        }

        return $this;
    }
}

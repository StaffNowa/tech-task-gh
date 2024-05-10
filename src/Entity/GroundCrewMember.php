<?php

namespace App\Entity;

use App\Repository\GroundCrewMemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GroundCrewMemberRepository::class)]
class GroundCrewMember
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    /**
     * @var Collection<int, Skill>
     */
    #[ORM\ManyToMany(targetEntity: Skill::class, inversedBy: 'groundCrewMembers')]
    private Collection $skills;

    /**
     * @var Collection<int, Certification>
     */
    #[ORM\ManyToMany(targetEntity: Certification::class, inversedBy: 'groundCrewMembers')]
    private Collection $certifications;

    /**
     * @var Collection<int, Flight>
     */
    #[ORM\ManyToMany(targetEntity: Flight::class, mappedBy: 'groundCrewMembers')]
    private Collection $flights;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
        $this->certifications = new ArrayCollection();
        $this->flights = new ArrayCollection();
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
     * @return Collection<int, Skill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        $this->skills->removeElement($skill);

        return $this;
    }

    /**
     * @return Collection<int, Certification>
     */
    public function getCertifications(): Collection
    {
        return $this->certifications;
    }

    public function addCertification(Certification $certification): static
    {
        if (!$this->certifications->contains($certification)) {
            $this->certifications->add($certification);
        }

        return $this;
    }

    public function removeCertification(Certification $certification): static
    {
        $this->certifications->removeElement($certification);

        return $this;
    }

    /**
     * @return Collection<int, Flight>
     */
    public function getFlights(): Collection
    {
        return $this->flights;
    }

    public function addFlight(Flight $flight): static
    {
        if (!$this->flights->contains($flight)) {
            $this->flights->add($flight);
            $flight->addGroundCrewMember($this);
        }

        return $this;
    }

    public function removeFlight(Flight $flight): static
    {
        if ($this->flights->removeElement($flight)) {
            $flight->removeGroundCrewMember($this);
        }

        return $this;
    }
}

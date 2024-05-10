<?php

namespace App\Entity;

use App\Repository\CertificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CertificationRepository::class)]
class Certification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $validFrom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $validUntil = null;

    /**
     * @var Collection<int, GroundCrewMember>
     */
    #[ORM\ManyToMany(targetEntity: GroundCrewMember::class, mappedBy: 'certifications')]
    private Collection $groundCrewMembers;

    #[ORM\Column(nullable: true)]
    private ?bool $expired = null;

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

    public function getValidFrom(): ?\DateTimeInterface
    {
        return $this->validFrom;
    }

    public function setValidFrom(\DateTimeInterface $validFrom): static
    {
        $this->validFrom = $validFrom;

        return $this;
    }

    public function getValidUntil(): ?\DateTimeInterface
    {
        return $this->validUntil;
    }

    public function setValidUntil(\DateTimeInterface $validUntil): static
    {
        $this->validUntil = $validUntil;

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
            $groundCrewMember->addCertification($this);
        }

        return $this;
    }

    public function removeGroundCrewMember(GroundCrewMember $groundCrewMember): static
    {
        if ($this->groundCrewMembers->removeElement($groundCrewMember)) {
            $groundCrewMember->removeCertification($this);
        }

        return $this;
    }

    public function isExpired(): ?bool
    {
        return $this->expired;
    }

    public function setExpired(?bool $expired): static
    {
        $this->expired = $expired;

        return $this;
    }
}

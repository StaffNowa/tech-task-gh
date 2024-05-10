<?php

namespace App\Entity;

use App\Repository\FlightRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FlightRepository::class)]
class Flight
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank]
    private ?string $flightNumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $flightDate = null;

    /**
     * @var Collection<int, Task>
     */
    #[ORM\OneToMany(targetEntity: Task::class, mappedBy: 'flight')]
    private Collection $tasks;

    /**
     * @var Collection<int, GroundCrewMember>
     */
    #[ORM\ManyToMany(targetEntity: GroundCrewMember::class, inversedBy: 'flights')]
    private Collection $groundCrewMembers;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
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

    public function getFlightNumber(): ?string
    {
        return $this->flightNumber;
    }

    public function setFlightNumber(string $flightNumber): static
    {
        $this->flightNumber = $flightNumber;

        return $this;
    }

    public function getFlightDate(): ?\DateTimeInterface
    {
        return $this->flightDate;
    }

    public function setFlightDate(\DateTimeInterface $flightDate): static
    {
        $this->flightDate = $flightDate;

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setFlight($this);
        }

        return $this;
    }

    public function removeTask(Task $task): static
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getFlight() === $this) {
                $task->setFlight(null);
            }
        }

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
        }

        return $this;
    }

    public function removeGroundCrewMember(GroundCrewMember $groundCrewMember): static
    {
        $this->groundCrewMembers->removeElement($groundCrewMember);

        return $this;
    }
}

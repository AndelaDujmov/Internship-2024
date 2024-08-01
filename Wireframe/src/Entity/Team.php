<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
#[ORM\Table(name:"team")]
class Team 
{

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36, unique: true)]
    private ?string $id = null;

    #[ORM\Column(length: 40)]
    private ?string $name = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'team', cascade: ['persist', 'remove'])]
    private Collection $members;

    #[ORM\Column]
    private ?int $numberOfMembers = null;

    public function __construct()
    {
        if ($this->id === null) {
            $this->id = Uuid::v4()->toRfc4122();
        }
        $this->members = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
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
     * @return Collection<int, User>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(User $member): static
    {
        if ($this->numberOfMembers !== null && $this->members->count() >= $this->numberOfMembers) {
            throw new \Exception('Cannot add more members. Maximum number reached.');
        }

        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->setTeam($this);
        }

        return $this;
    }

    public function removeMember(User $member): static
    {
        if ($this->members->removeElement($member)) {
            // set the owning side to null (unless already changed)
            if ($member->getTeam() === $this) {
                $member->setTeam(null);
            }
        }

        return $this;
    }

    public function getNumberOfMembers(): ?int
    {
        return $this->numberOfMembers;
    }

    public function setNumberOfMembers(int $numberOfMemers): static
    {
        $this->numberOfMembers = $numberOfMemers;

        return $this;
    }

}

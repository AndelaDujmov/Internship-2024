<?php

namespace App\Entity;

use App\Repository\TeamLeadersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TeamLeadersRepository::class)]
class TeamLeaders 
{
    
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36, unique: true)]
    private ?string $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $team = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $projectLeader = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $teamLead = null;

    public function __construct() {
        if ($this->id === null) {
            $this->id = Uuid::v4()->toRfc4122();
        }
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): static
    {
        $this->team = $team;

        return $this;
    }

    public function getProjectLeader(): ?User
    {
        return $this->projectLeader;
    }

    public function setProjectLeader(?User $projectLeader): static
    {
        $this->projectLeader = $projectLeader;

        return $this;
    }

    public function getTeamLead(): ?User
    {
        return $this->teamLead;
    }

    public function setTeamLead(?User $teamLead): static
    {
        $this->teamLead = $teamLead;

        return $this;
    }
}

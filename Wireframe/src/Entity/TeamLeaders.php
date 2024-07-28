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
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?UuidType $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Leader $projectLeader = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Leader $teamLeader = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $team = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getProjectLeader(): ?Leader
    {
        return $this->projectLeader;
    }

    public function setProjectLeader(?Leader $projectLeader): static
    {
        $this->projectLeader = $projectLeader;

        return $this;
    }

    public function getTeamLeader(): ?Leader
    {
        return $this->teamLeader;
    }

    public function setTeamLeader(?Leader $teamLeader): static
    {
        $this->teamLeader = $teamLeader;

        return $this;
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
}

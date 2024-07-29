<?php

namespace App\Entity;

use App\Enum\Status;
use App\Repository\RequestForALRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: RequestForALRepository::class)]
class RequestForAL
{ 
    
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36, unique: true)]
   private ?string $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $start = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $end = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reason = null;
      /**
     * @ORM\Column(type="string", length=20)
     */
    private Status $status;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateOfProcessing = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $worker = null;

    #[ORM\ManyToOne]
    private ?User $teamLeader = null;

    #[ORM\ManyToOne]
    private ?User $projectLeader = null;

    public function __construct() {
        if ($this->id === null) {
            $this->id = Uuid::v4()->toRfc4122();
        }
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): static
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): static
    {
        $this->end = $end;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): static
    {
        $this->reason = $reason;

        return $this;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    public function getDateOfProcessing(): ?\DateTimeInterface
    {
        return $this->dateOfProcessing;
    }

    public function setDateOfProcessing(\DateTimeInterface $dateOfProcessing): static
    {
        $this->dateOfProcessing = $dateOfProcessing;

        return $this;
    }

    public function getWorker(): ?User
    {
        return $this->worker;
    }

    public function setWorker(?User $worker): static
    {
        $this->worker = $worker;

        return $this;
    }

    public function getTeamLeader(): ?User
    {
        return $this->teamLeader;
    }

    public function setTeamLeader(?User $teamLeader): static
    {
        $this->teamLeader = $teamLeader;

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

}

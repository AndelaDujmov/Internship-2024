<?php

namespace App\Entity;

use App\Enum\Status;
use App\Repository\RequestForALRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RequestForALRepository::class)]
class RequestForAL
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Worker $worker = null;

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

    #[ORM\ManyToOne]
    private ?Leader $teamLeadApprove = null;

    #[ORM\ManyToOne]
    private ?Leader $projectLeadApproveal = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateOfProcessing = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorker(): ?Worker
    {
        return $this->worker;
    }

    public function setWorker(?Worker $worker): static
    {
        $this->worker = $worker;

        return $this;
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

    public function getTeamLeadApprove(): ?Leader
    {
        return $this->teamLeadApprove;
    }

    public function setTeamLeadApprove(?Leader $teamLeadApprove): static
    {
        $this->teamLeadApprove = $teamLeadApprove;

        return $this;
    }

    public function getProjectLeadApproveal(): ?Leader
    {
        return $this->projectLeadApproveal;
    }

    public function setProjectLeadApproveal(?Leader $projectLeadApproveal): static
    {
        $this->projectLeadApproveal = $projectLeadApproveal;

        return $this;
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

}

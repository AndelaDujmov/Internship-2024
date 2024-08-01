<?php

namespace App\Entity;

use App\Repository\AnnualLeaveRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints\Date;

#[ORM\Entity(repositoryClass: AnnualLeaveRepository::class)]
class AnnualLeave
{
   
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36, unique: true)]
    private ?string $id = null;

    #[ORM\Column]
    private ?int $year = null;
    
    #[ORM\Column]
    private ?int $totalDays = null;

    #[ORM\Column(length: 20)]
    private ?string $month = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $worker = null;

    public function __construct() {
        if ($this->id === null) {
            $this->id = Uuid::v4()->toRfc4122();
        }
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getTotalDays(): ?int
    {
        return $this->totalDays;
    }

    public function setTotalDays(int $totalDays): static
    {
        $this->totalDays = $totalDays;

        return $this;
    }

    public function getMonth(): ?string
    {
        return $this->month;
    }

    public function setMonth(string $month): static
    {
        $this->month = $month;

        return $this;
    }

    public function getWorker(): ?User
    {
        return $this->worker;
    }

    public function setWorker(?User $user): static
    {
        $this->worker = $user;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\AuthenticatedUserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AuthenticatedUserRepository::class)]
class AuthenticatedUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $name = null;

    #[ORM\Column]
    private array $roles = ['ROLE_USER'];

     /**
      * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min=8)
     * @Assert\Regex(
     *     pattern="/[A-Z]/",
     *     message="Password must contain at least one uppercase letter."
     * )
     * @Assert\Regex(
     *     pattern="/[\W_]/",
     *     message="Password must contain at least one special character."
     * )
     */
    #[ORM\Column]
    private ?string $password = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $contract_start_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $contract_end_date = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?bool $verified = null;
    
    public function getId(): ?int
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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->name;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        return array_unique($this->roles);
    }

    public function getRolesString(): string {
        $roles = array_unique($this->roles);
        sort($roles);

        return implode(', ', $roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function hasRole(string $role): bool {
        return in_array($role, $this->roles, true);
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getContractStartDate(): ?\DateTimeInterface
    {
        return $this->contract_start_date;
    }

    public function setContractStartDate(\DateTimeInterface $contract_start_date): static
    {
        $this->contract_start_date = $contract_start_date;

        return $this;
    }

    public function getContractEndDate(): ?\DateTimeInterface
    {
        return $this->contract_end_date;
    }

    public function setContractEndDate(\DateTimeInterface $contract_end_date): static
    {
        $this->contract_end_date = $contract_end_date;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function isVerified(): ?bool
    {
        return $this->verified;
    }

    public function setVerified(bool $verified): static
    {
        $this->verified = $verified;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}

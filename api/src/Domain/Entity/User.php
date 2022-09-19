<?php

namespace App\Domain\Entity;

use App\Application\Repository\UserRepository;
use App\Domain\Contract\Entity\EntityInterface;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface, EntityInterface
{
    const USER_ROLE = 'USER_ROLE';
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\Column(type: 'string', unique: true)]
    public $client_id;
    #[ORM\Column(type: 'string', unique: true)]
    private $username;
    #[ORM\Column(type: 'string')]
    private $password;
    #[ORM\Column(type: 'datetime')]
    private $created;
    #[ORM\Column(type: 'datetime')]
    private $updated;

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updatedTimestamps(): void
    {
        $this->setUpdatedAt(new DateTime('now'));

        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new DateTime('now'));
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): ?self
    {
        $this->id = $id;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setClientId(string $clientId): self
    {
        $this->client_id = $clientId;

        return $this;
    }

    public function setCreatedAt(DateTime $dateTime): self
    {
        $this->created = $dateTime;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->created;
    }

    public function setUpdatedAt(DateTime $dateTime): self
    {
        $this->updated = $dateTime;

        return $this;
    }

    public function getRoles(): array
    {
        return [
            self::USER_ROLE
        ];
    }

    public function eraseCredentials()
    {

    }

    public function getUserIdentifier(): string
    {
        return $this->client_id;
    }
}
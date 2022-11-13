<?php

namespace App\Domain\Entity;

use App\Domain\Contract\Entity\EntityInterface;
use App\Domain\Contract\Repository\CoinRepositoryInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoinRepositoryInterface::class)]
#[ORM\HasLifecycleCallbacks]
class Coin implements EntityInterface
{
    #[ORM\Column(name: 'full_name', type: 'string', unique: true, nullable: true)]
    private $fullName;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\Column(type: 'string', unique: true)]
    private $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function getPairName(): string
    {
        return $this->name . 'USDT';
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }
}

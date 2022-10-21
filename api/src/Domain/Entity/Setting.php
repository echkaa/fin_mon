<?php

namespace App\Domain\Entity;

use App\Domain\Contract\Entity\EntityInterface;
use App\Domain\Contract\Repository\SettingRepositoryInterface;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: SettingRepositoryInterface::class)]
#[ORM\HasLifecycleCallbacks]
class Setting implements EntityInterface, JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\Column(type: 'string', length: 255, nullable: true, name: 'binance_public_key')]
    private $binancePublicKey;
    #[ORM\Column(type: 'string', length: 255, nullable: true, name: 'binance_secret_key')]
    private $binanceSecretKey;
    #[ORM\Column(type: 'string', length: 255, nullable: true, name: 'mono_bank_token')]
    private $monoBankToken;
    #[ORM\OneToOne(targetEntity: User::class, inversedBy: 'setting')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private $user;

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function setBinancePublicKey(string $binancePublicKey): self
    {
        $this->binancePublicKey = $binancePublicKey;

        return $this;
    }

    public function getBinancePublicKey(): ?string
    {
        return $this->binancePublicKey;
    }

    public function setBinanceSecretKey(string $binanceSecretKey): self
    {
        $this->binanceSecretKey = $binanceSecretKey;

        return $this;
    }

    public function getBinanceSecretKey(): ?string
    {
        return $this->binanceSecretKey;
    }

    public function setMonoBankToken(string $monoBankToken): self
    {
        $this->monoBankToken = $monoBankToken;

        return $this;
    }

    public function getMonoBankToken(): ?string
    {
        return $this->monoBankToken;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'binance_public_key' => $this->getBinancePublicKey(),
            'binance_secret_key' => $this->getBinanceSecretKey(),
            'mono_bank_token' => $this->getMonoBankToken(),
        ];
    }
}

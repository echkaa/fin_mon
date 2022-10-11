<?php

namespace App\Domain\Entity;

use App\Domain\Contract\Repository\OperationRepositoryInterface;
use App\Domain\Contract\Entity\EntityInterface;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OperationRepositoryInterface::class)]
#[ORM\HasLifecycleCallbacks]
class Operation implements EntityInterface
{
    public const EXTERNAL_CODE_API = 'api';
    public const OPERATION_TYPE_FOOD = 'food';
    public const OPERATION_TYPE_MONTHLY = 'monthly';
    public const OPERATION_TYPE_DEPOSIT = 'deposit';
    public const OPERATION_TYPE_CAFE = 'cafe';
    public const OPERATION_TYPES = [
        self::OPERATION_TYPE_FOOD,
        self::OPERATION_TYPE_MONTHLY,
        self::OPERATION_TYPE_DEPOSIT,
        self::OPERATION_TYPE_CAFE,
    ];
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'operation')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private $user;
    #[ORM\Column(type: 'float')]
    private $amount;
    #[ORM\Column(type: 'integer', nullable: true)]
    private $type;
    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $source;
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $external_code;
    #[ORM\Column(type: 'datetime')]
    private $created;
    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated;

    #[ORM\PrePersist]
    public function onPrePersist()
    {
        $this->created = new DateTime("now");
    }

    #[ORM\PreUpdate]
    public function onPreUpdate()
    {
        $this->updated = new DateTime("now");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getExternalCode(): ?string
    {
        return $this->external_code;
    }

    public function setExternalCode(?string $externalCode): self
    {
        $this->external_code = $externalCode;

        return $this;
    }
}

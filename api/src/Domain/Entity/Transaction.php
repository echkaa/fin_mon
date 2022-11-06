<?php

namespace App\Domain\Entity;

use App\Domain\Contract\Entity\EntityInterface;
use App\Infrastructure\Persistence\MySQL\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Transaction implements EntityInterface
{
    public const BINANCE_SOURCE = 'binance';
    #[ORM\ManyToOne(targetEntity: Coin::class, inversedBy: 'transaction')]
    #[ORM\JoinColumn(name: 'coin_id', referencedColumnName: 'id', nullable: false)]
    private $coin;
    #[ORM\Column(type: 'datetime')]
    private $date;
    #[ORM\Column(type: 'float', name: 'fact_price')]
    private $factPrice;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\Column(type: 'boolean', name: 'is_buyer')]
    private $isBuyer;
    #[ORM\Column(type: 'float', name: 'market_price')]
    private $marketPrice;
    #[ORM\Column(type: 'float')]
    private $quantity;
    #[ORM\ManyToOne(targetEntity: Setting::class, inversedBy: 'transaction')]
    #[ORM\JoinColumn(name: 'setting_id', referencedColumnName: 'id', nullable: true)]
    private $setting;
    #[ORM\Column(type: 'string')]
    private $source;
    #[ORM\Column(type: 'integer', name: 'source_id', nullable: true)]
    private $sourceId;
    #[ORM\Column(type: 'float', name: 'total_quantity')]
    private $totalQuantity;

    public function setSetting(Setting $setting): self
    {
        $this->setting = $setting;

        return $this;
    }

    public function setCoin(Coin $coin): self
    {
        $this->coin = $coin;

        return $this;
    }

    public function setFactPrice(float $factPrice): self
    {
        $this->factPrice = $factPrice;

        return $this;
    }

    public function setMarketPrice(float $marketPrice): self
    {
        $this->marketPrice = $marketPrice;

        return $this;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function setTotalQuantity(float $totalQuantity): self
    {
        $this->totalQuantity = $totalQuantity;

        return $this;
    }

    public function setIsBuyer(bool $isBuyer): self
    {
        $this->isBuyer = $isBuyer;

        return $this;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function setSourceId(int $sourceId): self
    {
        $this->sourceId = $sourceId;

        return $this;
    }
}

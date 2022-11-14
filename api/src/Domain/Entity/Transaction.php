<?php

namespace App\Domain\Entity;

use App\Domain\Contract\Entity\EntityInterface;
use App\Infrastructure\Persistence\MySQL\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use JsonSerializable;
use Throwable;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Transaction implements EntityInterface, JsonSerializable
{
    public const BINANCE_SOURCE = 'binance';
    #[ORM\ManyToOne(targetEntity: Coin::class, inversedBy: 'transactions')]
    #[ORM\JoinColumn(name: 'coin_id', referencedColumnName: 'id', nullable: false)]
    private $coin;
    #[ORM\Column(type: 'datetime')]
    private $date;
    #[ORM\Column(type: 'decimal', name: 'fact_price', precision: 12, scale: 8)]
    private $factPrice;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\Column(type: 'boolean', name: 'is_buyer', precision: 12, scale: 8)]
    private $isBuyer;
    #[ORM\Column(type: 'decimal', name: 'market_price', precision: 12, scale: 8)]
    private $marketPrice;
    #[ORM\Column(type: 'decimal', precision: 14, scale: 8)]
    private $quantity;
    #[ORM\ManyToOne(targetEntity: Setting::class, inversedBy: 'transactions')]
    #[ORM\JoinColumn(name: 'setting_id', referencedColumnName: 'id', nullable: true)]
    private $setting;
    #[ORM\Column(type: 'string')]
    private $source;
    #[ORM\Column(type: 'integer', name: 'source_id', nullable: true)]
    private $sourceId;
    #[ORM\Column(type: 'decimal', name: 'total_quantity', precision: 12, scale: 8)]
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

    public function getCoin(): Coin
    {
        return $this->coin;
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

    public function getFactPrice(): float
    {
        return $this->factPrice;
    }

    public function getMarketPrice(): float
    {
        return $this->marketPrice;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getTotalQuantity(): float
    {
        return $this->totalQuantity;
    }

    public function getIsBuyer(): bool
    {
        return $this->isBuyer;
    }

    public function getSourceId(): int
    {
        return $this->sourceId;
    }

    public function getPNL(): float
    {
        return round(($this->marketPrice - $this->factPrice) * $this->quantity, 2);
    }

    public function getPNLPercent(): float
    {
        try {
            return round(($this->marketPrice * 100 / $this->factPrice) - 100, 2);
        } catch (Throwable) {
            return 0;
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            'factPrice' => $this->getFactPrice(),
            'marketPrice' => $this->getMarketPrice(),
            'quantity' => $this->getQuantity(),
            'totalQuantity' => $this->getTotalQuantity(),
            'pnl' => $this->getPNL(),
            'pnlPercent' => $this->getPNLPercent(),
            'isBuyer' => $this->getIsBuyer(),
            'date' => $this->getDate(),
            'coin' => $this->getCoin(),
        ];
    }
}

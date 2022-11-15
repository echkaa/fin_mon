<?php

namespace App\Domain\Entity;

use App\Domain\Contract\Entity\EntityInterface;
use App\Infrastructure\Persistence\MySQL\Repository\CoinPriceRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use JsonSerializable;

#[ORM\Entity(repositoryClass: CoinPriceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class CoinPrice implements EntityInterface, JsonSerializable
{
    public const TYPE_SOURCE = 'futures';
    public const SOURCE_BINANCE = 'binance';
    #[ORM\ManyToOne(targetEntity: Coin::class, inversedBy: 'transactions')]
    #[ORM\JoinColumn(name: 'coin_id', referencedColumnName: 'id', nullable: false)]
    private $coin;
    #[ORM\Column(type: 'datetime')]
    private $date;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\Column(type: 'decimal', name: 'market_price', precision: 12, scale: 8)]
    private $marketPrice;
    #[ORM\Column(type: 'string')]
    private $source;
    #[ORM\Column(type: 'string')]
    private $type;

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'marketPrice' => $this->getMarketPrice(),
            'date' => $this->getDate(),
            'coin' => $this->getCoin(),
        ];
    }

    public function getMarketPrice(): float
    {
        return $this->marketPrice;
    }

    public function setMarketPrice(float $marketPrice): self
    {
        $this->marketPrice = $marketPrice;

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

    public function getCoin(): Coin
    {
        return $this->coin;
    }

    public function setCoin(Coin $coin): self
    {
        $this->coin = $coin;

        return $this;
    }
}

<?php

namespace App\Domain\Entity;

use App\Domain\Contract\Entity\EntityInterface;
use App\Infrastructure\Persistence\MySQL\Repository\CoinPriceChangeRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use JsonSerializable;

#[ORM\Entity(repositoryClass: CoinPriceChangeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class CoinPriceChange implements EntityInterface, JsonSerializable
{
    public const TYPE_SOURCE = 'futures';
    public const SOURCE_BINANCE = 'binance';
    public const RANGE_MIN = '1m';
    public const RANGE_TWO_MIN = '2m';
    public const RANGE_FIVE_MIN = '5m';
    public const RANGE_TEN_MIN = '10m';
    public const RANGE_FIFTEEN_MIN = '15m';
    public const RANGE_TO_PERCENT = [
        self::RANGE_MIN => 2,
        self::RANGE_TWO_MIN => 3,
        self::RANGE_FIVE_MIN => 5,
        self::RANGE_TEN_MIN => 10,
        self::RANGE_FIFTEEN_MIN => 15,
    ];
    #[ORM\ManyToOne(targetEntity: Coin::class, inversedBy: 'transactions')]
    #[ORM\JoinColumn(name: 'coin_id', referencedColumnName: 'id', nullable: false)]
    private $coin;
    #[ORM\ManyToOne(targetEntity: CoinPriceChange::class, inversedBy: 'coin_price_change')]
    #[ORM\JoinColumn(name: 'previous_change_id', referencedColumnName: 'id', nullable: true)]
    private $previousChange;
    #[ORM\Column(type: 'datetime')]
    private $date;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\Column(type: 'decimal', name: 'market_price', precision: 16, scale: 8)]
    private $marketPrice;
    #[ORM\Column(type: 'string')]
    private $source;
    #[ORM\Column(type: 'string')]
    private $type;
    #[ORM\Column(type: 'string', name: 'time_range')]
    private $timeRange;
    #[ORM\Column(type: 'float', name: 'change_percent')]
    private $changePercent;

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

    public function getId(): int
    {
        return $this->id;
    }

    public function setPreviousChange(?CoinPriceChange $coinPriceChange): self
    {
        $this->previousChange = $coinPriceChange;

        return $this;
    }

    public function getPreviousChange(): ?CoinPriceChange
    {
        return $this->previousChange;
    }

    public function setTimeRange(string $timeRange): self
    {
        $this->timeRange = $timeRange;

        return $this;
    }

    public function setChangePercent(float $changePercent): self
    {
        $this->changePercent = $changePercent;

        return $this;
    }
}

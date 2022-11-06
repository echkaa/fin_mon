<?php

namespace App\Domain\Entity\DTO;

use App\Domain\Entity\Coin;
use Doctrine\Common\Collections\ArrayCollection;
use Throwable;

class BinanceBalanceCoin
{
    private float $factPrice = 1;
    private float $free = 0;
    private float $marketPrice = 1;
    private Coin $coin;
    /**
     * Collection[BinanceCoinTransaction]
     * */
    private ?ArrayCollection $transactions;

    public function setCoin(Coin $coin)
    {
        $this->coin = $coin;

        return $this;
    }

    public function getCoin(): Coin
    {
        return $this->coin;
    }

    public function getName(): string
    {
        return $this->coin->getName();
    }

    public function getPairName(): string
    {
        return $this->coin->getName() . 'USDT';
    }

    public function getFree(): float
    {
        return $this->free;
    }

    public function setFree(float $free): self
    {
        $this->free = $free;

        return $this;
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

    public function getFactPrice(): float
    {
        return $this->factPrice;
    }

    public function setFactPrice(float $factPrice): self
    {
        $this->factPrice = $factPrice;

        return $this;
    }

    public function getPNL(): float
    {
        return round(($this->marketPrice - $this->factPrice) * $this->free, 2);
    }

    public function getPNLPercent(): float
    {
        try {
            return round(($this->marketPrice * 100 / $this->factPrice) - 100, 2);
        } catch (Throwable) {
            return 0;
        }
    }

    public function setTransactions(ArrayCollection $transactions): self
    {
        $this->transactions = $transactions;

        return $this;
    }

    public function getTransactions(): ArrayCollection
    {
        return $this->transactions ?? new ArrayCollection();
    }
}

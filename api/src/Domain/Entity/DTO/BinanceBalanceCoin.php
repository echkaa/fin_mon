<?php

namespace App\Domain\Entity\DTO;

use Throwable;

class BinanceBalanceCoin
{
    private float $factPrice = 1;
    private float $free = 0;
    private float $marketPrice = 1;
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPairName(): string
    {
        return $this->name . 'USDT';
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
}

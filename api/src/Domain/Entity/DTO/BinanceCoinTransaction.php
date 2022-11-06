<?php

namespace App\Domain\Entity\DTO;

class BinanceCoinTransaction
{
    private float $count;
    private bool $isBuyer;
    private float $price;
    private int $time;

    public function setTime(int $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getIsBuyer(): bool
    {
        return $this->isBuyer;
    }

    public function setIsBuyer(bool $isBuyer): self
    {
        $this->isBuyer = $isBuyer;

        return $this;
    }

    public function getIsBuyerInt(): int
    {
        return $this->isBuyer ? 1 : -1;
    }

    public function getCount(): float
    {
        return $this->count;
    }

    public function setCount(float $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}

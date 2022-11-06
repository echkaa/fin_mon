<?php

namespace App\Domain\Entity\DTO;

use DateTime;
use Exception;

class BinanceCoinTransaction
{
    private float $quantity;
    private float $totalQuantity;
    private bool $isBuyer;
    private float $marketPrice;
    private float $factPrice;
    private int $time;
    private int $id;

    public function setTime(int $time): self
    {
        $this->time = (int)($time / 1000);

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

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

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

    public function setFactPrice(float $factPrice): self
    {
        $this->factPrice = $factPrice;

        return $this;
    }

    public function setTotalQuantity(float $totalQuantity): self
    {
        $this->totalQuantity = $totalQuantity;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function getDate(): DateTime
    {
        return (new DateTime())->setTimestamp($this->time);
    }

    public function getFactPrice(): float
    {
        return $this->factPrice;
    }

    public function getTotalQuantity(): float
    {
        return $this->totalQuantity;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }
}

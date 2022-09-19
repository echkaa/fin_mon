<?php

namespace App\Domain\Entity\DTO;

use Doctrine\Common\Collections\Collection;

class BinanceAccount
{
    private string $accountType;
    /**
     * Collection[BinanceBalanceCoin]
     * */
    private Collection $balanceCoins;
    private bool $canDeposit;
    private bool $canTrade;
    private bool $canWithdraw;

    public function setCanTrade(bool $canTrade): self
    {
        $this->canTrade = $canTrade;

        return $this;
    }

    public function setCanWithdraw(bool $canWithdraw): self
    {
        $this->canWithdraw = $canWithdraw;

        return $this;
    }

    public function setCanDeposit(bool $canDeposit): self
    {
        $this->canDeposit = $canDeposit;

        return $this;
    }

    public function setAccountType(string $accountType): self
    {
        $this->accountType = $accountType;

        return $this;
    }

    public function getBalanceCoins(): Collection
    {
        return $this->balanceCoins;
    }

    public function setBalanceCoins(Collection $balanceCoins): self
    {
        $this->balanceCoins = $balanceCoins;

        return $this;
    }
}

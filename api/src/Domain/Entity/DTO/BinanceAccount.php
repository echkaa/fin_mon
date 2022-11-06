<?php

namespace App\Domain\Entity\DTO;

use Doctrine\Common\Collections\ArrayCollection;

class BinanceAccount
{
    private string $accountType;
    /**
     * ArrayCollection[BinanceBalanceCoin]
     * */
    private ArrayCollection $balanceCoins;
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

    public function getBalanceCoins(): ArrayCollection
    {
        return $this->balanceCoins;
    }

    public function setBalanceCoins(ArrayCollection $balanceCoins): self
    {
        $this->balanceCoins = $balanceCoins;

        return $this;
    }
}

<?php

namespace App\Application\Service;

use App\Domain\Contract\Repository\CoinRepositoryInterface;
use App\Domain\Entity\Coin;
use Doctrine\Common\Collections\ArrayCollection;

class CoinService
{
    private ?ArrayCollection $coinList = null;

    public function __construct(
        private CoinRepositoryInterface $coinRepository
    ) {
    }

    public function getAllCoin(): ArrayCollection
    {
        if ($this->coinList === null) {
            $this->setCoinList();
        }

        return $this->coinList;
    }

    private function setCoinList(): void
    {
        $this->coinList = new ArrayCollection();

        /* @var Coin $coin */
        foreach ($this->coinRepository->all() as $coin) {
            $this->coinList->set(
                $coin->getName(),
                $coin,
            );
        }
    }

    public function getCoinByName(string $name): ?Coin
    {
        if ($this->coinList === null) {
            $this->setCoinList();
        }

        return $this->coinList->get($name);
    }
}

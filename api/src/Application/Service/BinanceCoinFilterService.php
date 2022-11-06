<?php

namespace App\Application\Service;

use App\Domain\Entity\DTO\BinanceBalanceCoin;
use Doctrine\Common\Collections\ArrayCollection;

class BinanceCoinFilterService
{
    public function filterCoins(ArrayCollection $coins): ArrayCollection
    {
        return $coins->filter(
            function (BinanceBalanceCoin $coin) {
                return $coin->getPNL() != 0 && $coin->getFactPrice() != 1;
            }
        );
    }

    public function filterCoinsByList(ArrayCollection $coins, array $coinNeedList): ArrayCollection
    {
        return $coins->filter(
            function (BinanceBalanceCoin $coin) use ($coinNeedList) {
                return empty($coinNeedList) || in_array($coin->getName(), $coinNeedList);
            }
        );
    }
}

<?php

namespace App\Application\Service;

use App\Domain\Entity\DTO\BinanceBalanceCoin;
use Doctrine\Common\Collections\Collection;

class BinanceCoinFilterService
{
    public function filterCoins(Collection $coins): Collection
    {
        return $coins->filter(
            function (BinanceBalanceCoin $coin) {
                return $coin->getPNL() != 0 && $coin->getFactPrice() != 1;
            }
        );
    }

    public function filterCoinsByList(Collection $coins, array $coinNeedList): Collection
    {
        return $coins->filter(
            function (BinanceBalanceCoin $coin) use ($coinNeedList) {
                return empty($coinNeedList) || in_array($coin->getName(), $coinNeedList);
            }
        );
    }
}

<?php

namespace App\Application\Command\Binance\StatisticCoins;

use App\Application\Command\AbstractCommand;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     example={
 *         "coins": "{'BTC', 'ETH', 'ETC}"
 *     }
 * )
 */
class BinanceStatisticCoinsCommand extends AbstractCommand
{
    protected ?array $coins = null;

    public function getCoins(): array
    {
        return $this->coins ?? [];
    }
}

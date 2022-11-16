<?php

namespace App\Application\Command\Binance\StatisticCoins;

use App\Application\Command\AbstractCommand;
use App\Domain\Contract\Command\AsyncCommandInterface;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     example={
 *         "coins": "{'BTC', 'ETH', 'ETC}"
 *     }
 * )
 */
class StatisticCoinsCommand extends AbstractCommand implements AsyncCommandInterface
{
    protected ?array $coins = null;

    public function getCoins(): array
    {
        return $this->coins ?? [];
    }
}

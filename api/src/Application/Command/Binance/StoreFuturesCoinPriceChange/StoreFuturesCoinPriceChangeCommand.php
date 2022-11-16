<?php

namespace App\Application\Command\Binance\StoreFuturesCoinPriceChange;

use App\Application\Command\AbstractCommand;
use App\Domain\Contract\Command\SyncCommandInterface;

class StoreFuturesCoinPriceChangeCommand extends AbstractCommand implements SyncCommandInterface
{
    private string $timeRange;

    public function setTimeRange(string $timeRange): self
    {
        $this->timeRange = $timeRange;

        return $this;
    }

    public function getTimeRange(): string
    {
        return $this->timeRange;
    }
}

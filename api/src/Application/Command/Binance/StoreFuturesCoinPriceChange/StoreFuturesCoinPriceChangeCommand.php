<?php

namespace App\Application\Command\Binance\StoreFuturesCoinPriceChange;

use App\Application\Command\AbstractCommand;
use App\Domain\Contract\Command\AsyncCommandInterface;

class StoreFuturesCoinPriceChangeCommand extends AbstractCommand implements AsyncCommandInterface
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

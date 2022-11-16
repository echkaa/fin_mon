<?php

namespace App\Application\Command\CoinPriceChange\CheckByAlgorithm;

use App\Application\Command\AbstractCommand;
use App\Domain\Contract\Command\SyncCommandInterface;

class CheckByAlgorithmCommand extends AbstractCommand implements SyncCommandInterface
{
    private string $timeRange;

    public function getTimeRange(): string
    {
        return $this->timeRange;
    }

    public function setTimeRange(string $timeRange): self
    {
        $this->timeRange = $timeRange;

        return $this;
    }
}

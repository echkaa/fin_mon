<?php

namespace App\Application\Command\CoinPriceChange\CheckByAlgorithm;

use App\Application\Command\AbstractCommand;
use App\Domain\Contract\Command\AsyncCommandInterface;

class CheckByAlgorithmCommand extends AbstractCommand implements AsyncCommandInterface
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

<?php

namespace App\Application\Command\Binance\ClearOldFuturesCoinPrice;

use App\Application\Command\AbstractCommand;
use App\Domain\Contract\Command\AsyncCommandInterface;
use DateTime;

class ClearOldFuturesCoinPriceCommand extends AbstractCommand implements AsyncCommandInterface
{
    private DateTime $deletedTo;

    public function getDeletedTo(): DateTime
    {
        return $this->deletedTo;
    }

    public function setDeletedTo(DateTime $deletedTo): self
    {
        $this->deletedTo = $deletedTo;

        return $this;
    }
}

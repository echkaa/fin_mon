<?php

namespace App\Application\Command\Binance\ClearOldFuturesCoinPrice;

use App\Application\Command\AbstractCommand;
use DateTime;

class ClearOldFuturesCoinPriceCommand extends AbstractCommand
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

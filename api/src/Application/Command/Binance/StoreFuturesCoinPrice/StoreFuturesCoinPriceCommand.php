<?php

namespace App\Application\Command\Binance\StoreFuturesCoinPrice;

use App\Application\Command\AbstractCommand;
use App\Domain\Contract\Command\AsyncCommandInterface;

class StoreFuturesCoinPriceCommand extends AbstractCommand implements AsyncCommandInterface
{
}

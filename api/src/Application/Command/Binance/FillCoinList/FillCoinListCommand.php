<?php

namespace App\Application\Command\Binance\FillCoinList;

use App\Application\Command\AbstractCommand;
use App\Domain\Contract\Command\AsyncCommandInterface;

class FillCoinListCommand extends AbstractCommand implements AsyncCommandInterface
{
}

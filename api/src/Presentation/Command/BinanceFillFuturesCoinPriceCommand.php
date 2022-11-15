<?php

namespace App\Presentation\Command;

use App\Application\Command\Binance\StoreFuturesCoinPrice\StoreFuturesCoinPriceCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class BinanceFillFuturesCoinPriceCommand extends Command
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
        parent::__construct();
    }

    public static function getDefaultName(): string
    {
        return 'binance:fill:futures:coin_price';
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->messageBus->dispatch(
            new StoreFuturesCoinPriceCommand()
        );

        return self::SUCCESS;
    }
}

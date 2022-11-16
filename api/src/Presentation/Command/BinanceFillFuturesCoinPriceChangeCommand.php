<?php

namespace App\Presentation\Command;

use App\Application\Command\Binance\StoreFuturesCoinPriceChange\StoreFuturesCoinPriceChangeCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class BinanceFillFuturesCoinPriceChangeCommand extends Command
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
        parent::__construct();
    }

    public static function getDefaultName(): string
    {
        return 'binance:fill:futures:coin_price_change';
    }

    protected function configure(): void
    {
        $this->addArgument('range', InputArgument::REQUIRED, 'Range time');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->messageBus->dispatch(
            (new StoreFuturesCoinPriceChangeCommand())
                ->setTimeRange($input->getArgument('range'))
        );

        return self::SUCCESS;
    }
}

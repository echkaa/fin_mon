<?php

namespace App\Presentation\Command;

use App\Application\Command\Binance\ClearOldFuturesCoinPrice\ClearOldFuturesCoinPriceCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use DateTime;
use DateInterval;

class BinanceClearOldFuturesCoinPriceCommand extends Command
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
        parent::__construct();
    }

    public static function getDefaultName(): string
    {
        return 'binance:clear_old:futures:coin_price';
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dateTime = new DateTime();
        $dateTime->sub(new DateInterval('P1D'));

        $this->messageBus->dispatch(
            (new ClearOldFuturesCoinPriceCommand())
                ->setDeletedTo($dateTime)
        );

        return self::SUCCESS;
    }
}

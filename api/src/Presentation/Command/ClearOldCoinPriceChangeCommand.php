<?php

namespace App\Presentation\Command;

use App\Application\Command\CoinPriceChange\ClearOld\ClearOldCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use DateTime;
use DateInterval;

class ClearOldCoinPriceChangeCommand extends Command
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
        parent::__construct();
    }

    public static function getDefaultName(): string
    {
        return 'clear_old:coin_price_price';
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dateTime = new DateTime();
        $dateTime->sub(new DateInterval('P1D'));

        $this->messageBus->dispatch(
            (new ClearOldCommand())
                ->setDeletedTo($dateTime)
        );

        return self::SUCCESS;
    }
}

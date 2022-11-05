<?php

namespace App\Presentation\Command;

use App\Application\Command\Binance\FillCoinList\BinanceFillCoinListCommand as FillCoinListCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class BinanceCoinListFillCommand extends Command
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
        parent::__construct();
    }

    public static function getDefaultName(): string
    {
        return 'coin:list:fill';
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->messageBus->dispatch(
            new FillCoinListCommand()
        );

        return self::SUCCESS;
    }
}

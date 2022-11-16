<?php

namespace App\Presentation\Command;

use App\Application\Command\MonoBankOperation\Setting\SettingCommand as MonoBankSettingCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class MonoBankOperationSettingCommand extends Command
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
        parent::__construct();
    }

    public static function getDefaultName(): string
    {
        return 'mono-bank:operations:setting';
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->messageBus->dispatch(
            new MonoBankSettingCommand()
        );

        return self::SUCCESS;
    }
}

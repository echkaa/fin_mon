<?php

namespace App\Presentation\Command;

use App\Application\Command\Binance\FillUserWallet\BinanceFillUserWalletCommand;
use App\Domain\Contract\Repository\SettingRepositoryInterface;
use App\Domain\Entity\Setting;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class BinanceFillUsersWalletCommand extends Command
{
    public function __construct(
        private MessageBusInterface $messageBus,
        private SettingRepositoryInterface $settingRepository,
    ) {
        parent::__construct();
    }

    public static function getDefaultName(): string
    {
        return 'binance:fill:user:wallet';
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $settings = $this->settingRepository->getBinanceKeysNotNullList();

        /* @var Setting $settings */
        foreach ($settings as $setting) {
            $this->messageBus->dispatch(
                (new BinanceFillUserWalletCommand())
                    ->setUserId($setting->getUser()->getId())
            );
        }

        return self::SUCCESS;
    }
}

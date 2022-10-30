<?php

namespace App\Application\TelegramHandler;

use App\Application\Service\BinanceCoinService;
use App\Domain\Contract\Handler\TelegramHandlerInterface;
use App\Domain\Entity\DTO\BinanceBalanceCoin;
use App\Infrastructure\Adapter\TelegramAdapter;

class CoinStatisticHandler implements TelegramHandlerInterface
{
    const COIN_MESSAGE_SAMPLE = '%s; PNL: %d; PNL (percent): %d';

    public function __construct(
        private BinanceCoinService $coinService,
        private TelegramAdapter $adapter,
    ) {
    }

    public function getButtonText(): string
    {
        return 'coins';
    }

    public function execute(int $telegramChatId): void
    {
        $coins = $this->coinService->getStatisticCoins();

        $coins->map(function (BinanceBalanceCoin $coin) use ($telegramChatId) {
            $message = sprintf(
                self::COIN_MESSAGE_SAMPLE,
                $coin->getName(),
                $coin->getPNL(),
                $coin->getPNLPercent(),
            );

            $this->adapter->sendMessage(
                $telegramChatId,
                $message
            );
        });
    }
}

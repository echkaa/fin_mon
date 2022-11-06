<?php

namespace App\Application\TelegramHandler;

use App\Application\Service\BinanceAccountBuilderService;
use App\Application\Service\BinanceAccountCoinFillService;
use App\Application\Service\BinanceCoinFilterService;
use App\Domain\Contract\Handler\TelegramHandlerInterface;
use App\Domain\Entity\DTO\BinanceBalanceCoin;
use App\Infrastructure\Adapter\TelegramAdapter;

class CoinStatisticHandler implements TelegramHandlerInterface
{
    const COIN_MESSAGE_SAMPLE = '%s; PNL: %d; PNL (percent): %d';

    public function __construct(
        private TelegramAdapter $adapter,
        private BinanceAccountBuilderService $accountBuilderService,
        private BinanceAccountCoinFillService $coinFillService,
        private BinanceCoinFilterService $coinFilterService,
    ) {
    }

    public function getButtonText(): string
    {
        return 'coins';
    }

    public function execute(int $telegramChatId): void
    {
        $account = $this->accountBuilderService->getAccount();
        $this->accountBuilderService->setTransactionByAccount($account);

        $this->coinFillService->fillFullStatCoinsByAccount($account);

        $this->coinFilterService
            ->filterCoins($account->getBalanceCoins())
            ->map(
                function (BinanceBalanceCoin $coin) use ($telegramChatId) {
                    $this->adapter->sendMessage(
                        $telegramChatId,
                        $this->buildMessage($coin),
                    );
                }
            );
    }

    private function buildMessage(BinanceBalanceCoin $coin)
    {
        return sprintf(
            self::COIN_MESSAGE_SAMPLE,
            $coin->getName(),
            $coin->getPNL(),
            $coin->getPNLPercent(),
        );
    }
}

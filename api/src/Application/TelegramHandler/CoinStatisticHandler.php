<?php

namespace App\Application\TelegramHandler;

use App\Application\Service\TransactionService;
use App\Domain\Contract\Handler\TelegramHandlerInterface;
use App\Domain\Entity\Transaction;
use App\Infrastructure\Adapter\TelegramAdapter;

class CoinStatisticHandler implements TelegramHandlerInterface
{
    const COIN_MESSAGE_SAMPLE = '%s; PNL: %d; PNL (percent): %d';

    public function __construct(
        private TelegramAdapter $adapter,
        private TransactionService $transactionService,
    ) {
    }

    public function getButtonText(): string
    {
        return 'coins';
    }

    public function execute(int $telegramChatId): void
    {
        $transactions = $this->transactionService->getLastTransactionsForCurrentUser();

        $this->transactionService->updateMarketPriceOnTransactions($transactions);

        $this->transactionService->filterTransactionsByValue($transactions)
            ->map(
                function (Transaction $transaction) use ($telegramChatId) {
                    $this->adapter->sendMessage(
                        $telegramChatId,
                        $this->buildMessage($transaction),
                    );
                }
            );
    }

    private function buildMessage(Transaction $transaction)
    {
        return sprintf(
            self::COIN_MESSAGE_SAMPLE,
            $transaction->getCoin()->getName(),
            $transaction->getPNL(),
            $transaction->getPNLPercent(),
        );
    }
}

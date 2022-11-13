<?php

namespace App\Application\Service\DTO;

use App\Application\Factory\DTO\BinanceAccountFactory;
use App\Application\Factory\DTO\BinanceTransactionFactory;
use App\Application\Request\Binance\AccountBinanceRequest;
use App\Application\Request\Binance\MyTradesRequest;
use App\Application\Service\UserService;
use App\Domain\Contract\Repository\TransactionRepositoryInterface;
use App\Domain\Entity\DTO\BinanceAccount;
use App\Domain\Entity\DTO\BinanceBalanceCoin;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NoResultException;
use GuzzleHttp\Exception\GuzzleException;

class BinanceAccountBuilderService
{
    public function __construct(
        private MyTradesRequest $myTradesRequest,
        private AccountBinanceRequest $accountBinanceRequest,
        private BinanceAccountFactory $binanceAccountFactory,
        private BinanceTransactionFactory $binanceTransactionFactory,
        private TransactionRepositoryInterface $transactionRepository,
        private UserService $userService,
    ) {
    }

    public function getAccount(): BinanceAccount
    {
        $accountData = $this->accountBinanceRequest->sendRequest();

        return $this->binanceAccountFactory->create($accountData);
    }

    public function setTransactionByAccount(BinanceAccount $account): void
    {
        $account->getBalanceCoins()->map(
            fn(BinanceBalanceCoin $coin) => $this->setTransactionsToCoin($coin)
        );
    }

    public function setTransactionsToCoin(BinanceBalanceCoin $binanceCoin): BinanceBalanceCoin
    {
        try {
            $transaction = $this->transactionRepository->getLastTransactionByCoin(
                $this->userService->getCurrentUser(),
                $binanceCoin->getCoin(),
            );
        } catch (NoResultException) {
            $transaction = null;
        }

        try {
            $binanceTransactionList = $this->binanceTransactionFactory->getTransactionListFromBinanceTrades(
                $this->myTradesRequest->sendRequest(
                    symbol: $binanceCoin->getPairName(),
                    fromId: $transaction?->getSourceId(),
                )
            );

            if ($transaction !== null) {
                $binanceTransactionList->set(
                    0,
                    $this->binanceTransactionFactory->getBinanceTransactionFromTransaction($transaction)
                );
            }

            $binanceCoin->setTransactions($binanceTransactionList);
        } catch (GuzzleException) {
        }

        return $binanceCoin;
    }
}

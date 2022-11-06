<?php

namespace App\Application\Service;

use App\Application\Factory\DTO\BinanceAccountFactory;
use App\Application\Factory\DTO\BinanceTransactionFactory;
use App\Application\Request\Binance\AccountBinanceRequest;
use App\Application\Request\Binance\MyTradesRequest;
use App\Domain\Entity\DTO\BinanceAccount;
use App\Domain\Entity\DTO\BinanceBalanceCoin;
use GuzzleHttp\Exception\GuzzleException;

class BinanceAccountBuilderService
{
    public function __construct(
        private MyTradesRequest $myTradesRequest,
        private AccountBinanceRequest $accountBinanceRequest,
        private BinanceAccountFactory $binanceAccountFactory,
        private BinanceTransactionFactory $binanceTransactionFactory,
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

    public function setTransactionsToCoin(BinanceBalanceCoin $coin): BinanceBalanceCoin
    {
        /*TODO::here search in DB*/

        try {
            $trades = $this->myTradesRequest->sendRequest($coin->getPairName());
            $transactions = $this->binanceTransactionFactory->getTransactionListFromBinanceTrades($trades);

            $coin->setTransactions($transactions);
        } catch (GuzzleException) {
        }

        return $coin;
    }
}

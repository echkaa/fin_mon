<?php

namespace App\Application\Factory\DTO;

use App\Application\Service\CoinService;
use App\Domain\Entity\DTO\BinanceAccount;
use App\Domain\Entity\DTO\BinanceBalanceCoin;
use Doctrine\Common\Collections\ArrayCollection;

class BinanceAccountFactory
{
    public function __construct(
        private CoinService $coinService,
    ) {
    }

    public function create(array $accountData): BinanceAccount
    {
        $binanceAccount = (new BinanceAccount())
            ->setCanDeposit($accountData['canDeposit'] ?? false)
            ->setCanTrade($accountData['canTrade'] ?? false)
            ->setCanWithdraw($accountData['canWithdraw'] ?? false)
            ->setAccountType($accountData['accountType'] ?? '');

        $binanceAccount->setBalanceCoins(
            $this->getBalanceCoinsCollection($accountData['balances'] ?? []),
        );

        return $binanceAccount;
    }

    private function getBalanceCoinsCollection(array $balances): ArrayCollection
    {
        return (new ArrayCollection($balances))
            ->filter(fn($item) => $item['free'] > 0 && $this->coinService->getCoinByName($item['asset']))
            ->map(fn($item) => $this->getBalanceCoin($item));
    }

    private function getBalanceCoin(array $data): BinanceBalanceCoin
    {
        return (new BinanceBalanceCoin())
            ->setFree($data['free'])
            ->setCoin($this->coinService->getCoinByName($data['asset']));
    }
}

<?php

namespace App\Application\Request\Binance;

use App\Application\Client\BinanceClient;
use App\Application\Factory\TokenBinanceFactory;
use App\Domain\Entity\BinanceToken;

abstract class AbstractBinanceRequest
{
    public function __construct(
        protected BinanceClient $binanceClient,
        private TokenBinanceFactory $tokenBinanceFactory,
    ) {
    }

    protected function getRequestToken(string $publicKey, string $privateKey): BinanceToken
    {
        return $this->tokenBinanceFactory->create(
            publicKey: $publicKey,
            privateKey: $privateKey,
            params: $this->getData(),
        );
    }

    private function getData(): array
    {
        return [];
    }
}

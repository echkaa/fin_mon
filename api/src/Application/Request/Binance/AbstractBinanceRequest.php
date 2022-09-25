<?php

namespace App\Application\Request\Binance;

use App\Infrastructure\Client\BinanceClient;
use App\Application\Factory\TokenBinanceFactory;
use App\Domain\Entity\BinanceToken;
use Symfony\Component\HttpFoundation\RequestStack;

abstract class AbstractBinanceRequest
{
    public function __construct(
        private RequestStack $requestStack,
        protected BinanceClient $binanceClient,
        private TokenBinanceFactory $tokenBinanceFactory,
    ) {
    }

    protected function getRequestToken(array $params = []): BinanceToken
    {
        $request = $this->requestStack->getCurrentRequest();

        return $this->tokenBinanceFactory->create(
            publicKey: $request->query->get('public_key', ''),
            privateKey: $request->query->get('private_key', ''),
            params: $params,
        );
    }
}

<?php

namespace App\Application\Request\Binance;

use App\Application\Service\UserService;
use App\Infrastructure\Client\BinanceClient;
use App\Application\Factory\TokenBinanceFactory;
use App\Domain\Entity\DTO\BinanceToken;

abstract class AbstractBinanceRequest
{
    public function __construct(
        protected BinanceClient $binanceClient,
        private TokenBinanceFactory $tokenBinanceFactory,
        private UserService $userService,
    ) {
    }

    protected function getRequestToken(array $params = []): BinanceToken
    {
        return $this->tokenBinanceFactory->create(
            publicKey: $this->userService->getCurrentUser()->getSetting()->getBinancePublicKey(),
            privateKey: $this->userService->getCurrentUser()->getSetting()->getBinancePrivateKey(),
            params: $params,
        );
    }
}

<?php

namespace App\Application\Request\Binance;

use GuzzleHttp\Exception\GuzzleException;

class AccountBinanceRequest extends AbstractBinanceRequest
{
    /**
     * @throws GuzzleException
     */
    public function sendRequest(string $publicKey, string $privateKey): array
    {
        $response = $this->binanceClient->getAccountData(
            $this->getRequestToken(
                $publicKey,
                $privateKey,
            ),
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    private function getData(): array
    {
        return [];
    }
}

<?php

namespace App\Application\Request\Binance;

use GuzzleHttp\Exception\GuzzleException;

class AccountBinanceRequest extends AbstractBinanceRequest
{
    /**
     * @throws GuzzleException
     */
    public function sendRequest(): array
    {
        $response = $this->binanceClient->getAccountData(
            $this->getRequestToken(),
        );

        return json_decode($response->getBody()->getContents(), true);
    }
}

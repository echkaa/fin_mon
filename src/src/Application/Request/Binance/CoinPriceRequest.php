<?php

namespace App\Application\Request\Binance;

use GuzzleHttp\Exception\GuzzleException;

class CoinPriceRequest extends AbstractBinanceRequest
{
    /**
     * @throws GuzzleException
     */
    public function sendRequest(string $coinName): array
    {
        $response = $this->binanceClient->getCoinPrice($coinName);

        return json_decode($response->getBody()->getContents(), true);
    }
}

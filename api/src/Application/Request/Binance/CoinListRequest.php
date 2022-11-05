<?php

namespace App\Application\Request\Binance;

use GuzzleHttp\Exception\GuzzleException;

class CoinListRequest extends AbstractBinanceRequest
{
    /**
     * @throws GuzzleException
     */
    public function sendRequest(): array
    {
        $response = $this->binanceClient->getCoinList();

        return json_decode($response->getBody()->getContents(), true);
    }
}

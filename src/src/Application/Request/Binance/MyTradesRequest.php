<?php

namespace App\Application\Request\Binance;

use GuzzleHttp\Exception\GuzzleException;

class MyTradesRequest extends AbstractBinanceRequest
{
    /**
     * @throws GuzzleException
     */
    public function sendRequest(string $symbol): array
    {
        $response = $this->binanceClient->getMyTrades(
            $this->getRequestToken(
                [
                    'symbol' => $symbol,
                ],
            ),
        );

        return json_decode($response->getBody()->getContents(), true);
    }
}

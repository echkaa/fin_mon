<?php

namespace App\Application\Request\Binance;

use GuzzleHttp\Exception\GuzzleException;

class MyTradesRequest extends AbstractBinanceRequest
{
    /**
     * @throws GuzzleException
     */
    public function sendRequest(string $symbol, ?int $fromId = null): array
    {
        $response = $this->binanceClient->getMyTrades(
            $this->getRequestToken(
                [
                    'symbol' => $symbol,
                    'fromId' => $fromId,
                ],
            ),
        );

        return json_decode($response->getBody()->getContents(), true);
    }
}

<?php

namespace App\Infrastructure\Client;

use App\Domain\Entity\DTO\BinanceToken;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class BinanceClient
{
    private const ACCOUNT_URL = 'api/v3/account';
    private const MY_TRADES_URL = 'api/v3/myTrades';
    private const COIN_PRICE_URL = 'api/v3/avgPrice';

    public function __construct(
        private ClientInterface $client,
        private string $binanceAPIUrl,
    ) {
    }

    /**
     * @throws GuzzleException
     */
    public function getAccountData(BinanceToken $token): ResponseInterface
    {
        return $this->requestWithTokenGET(
            url: self::ACCOUNT_URL,
            token: $token,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function getMyTrades(BinanceToken $token): ResponseInterface
    {
        return $this->requestWithTokenGET(
            url: self::MY_TRADES_URL,
            token: $token,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function getCoinPrice(string $coinName): ResponseInterface
    {
        return $this->requestGET(
            url: self::COIN_PRICE_URL,
            params: [
                'symbol' => $coinName . 'USDT',
            ],
        );
    }

    /**
     * @throws GuzzleException
     */
    private function requestWithTokenGET(string $url, BinanceToken $token): ResponseInterface
    {
        return $this->client->request(
            method: 'GET',
            uri: $this->binanceAPIUrl . $url . '?' . $token->getParamsHttpWithToken(),
            options: [
                'headers' => [
                    'X-MBX-APIKEY' => $token->getPublicKey(),
                ],
            ]
        );
    }

    /**
     * @throws GuzzleException
     */
    private function requestGET(string $url, array $params): ResponseInterface
    {
        return $this->client->request(
            method: 'GET',
            uri: $this->binanceAPIUrl . $url . '?' . http_build_query($params),
        );
    }
}

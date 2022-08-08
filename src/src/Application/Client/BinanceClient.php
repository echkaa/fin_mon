<?php

namespace App\Application\Client;

use App\Domain\Entity\BinanceToken;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class BinanceClient
{
    private const ACCOUNT_URL = 'api/v3/account';

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
        return $this->requestGET(
            url: self::ACCOUNT_URL,
            token: $token,
        );
    }

    /**
     * @throws GuzzleException
     */
    private function requestGET(string $url, BinanceToken $token): ResponseInterface
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
}

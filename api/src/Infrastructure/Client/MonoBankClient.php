<?php

namespace App\Infrastructure\Client;

use App\Domain\Entity\DTO\BinanceToken;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class MonoBankClient
{
    private const USER_INFO_URL = 'personal/client-info';
    private const STATEMENT_URL = 'personal/statement/%s/%s/%s';

    public function __construct(
        private ClientInterface $client,
        private string $monoBankAPIUrl,
    ) {
    }

    /**
     * @throws GuzzleException
     */
    public function getClientInfo(string $token): ResponseInterface
    {
        return $this->requestWithTokenGET(
            url: self::USER_INFO_URL,
            token: $token,
        );
    }

    /**
     * @throws GuzzleException
     */
    private function requestWithTokenGET(string $url, string $token): ResponseInterface
    {
        return $this->client->request(
            method: 'GET',
            uri: $this->monoBankAPIUrl . $url,
            options: [
                'headers' => [
                    'X-Token' => $token,
                ],
            ]
        );
    }

    /**
     * @throws GuzzleException
     */
    public function getStatement(string $token, int $from, int $account = 0, ?int $to = null): ResponseInterface
    {
        $url = sprintf(
            self::STATEMENT_URL,
            $account,
            $from,
            $to,
        );

        return $this->requestWithTokenGET(
            url: str_replace('//', '/', $url),
            token: $token,
        );
    }
}

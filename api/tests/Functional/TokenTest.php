<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TokenTest extends WebTestCase
{
    private string $uri = '/v1/auth/token';

    public function testErrorRequest(): void
    {
        $client = static::createClient();
        $crawler = $client->request(
            method: 'POST',
            uri: $this->uri,
            parameters: []
        );

        $this->assertResponseStatusCodeSame(500);
    }

    public function testSuccessRequest(): void
    {
        $client = static::createClient();
        $crawler = $client->request(
            method: 'POST',
            uri: $this->uri,
            parameters: [
                'password' => 'mypassword',
                'username' => 'oleksii_kava',
                'scope' => 'https://fin_mon.ua/',
            ]
        );

        $this->assertResponseStatusCodeSame(200);
    }
}

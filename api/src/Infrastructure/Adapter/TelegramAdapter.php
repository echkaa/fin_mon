<?php

namespace App\Infrastructure\Adapter;

use TelegramBot\Api\Client;
use TelegramBot\Api\InvalidJsonException;

class TelegramAdapter
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    public function setCommand(string $commandName, callable $callback): void
    {
        $this->client->command($commandName, $callback);
    }

    public function setOn(callable $callback): void
    {
        $this->client->on(
            $callback,
            fn() => true
        );
    }

    public function sendMessage(int $chatId, string $message): void
    {
        $this->client->sendMessage(
            $chatId,
            $message,
        );
    }

    /**
     * @throws InvalidJsonException
     */
    public function run(): void
    {
        $this->client->run();
    }
}

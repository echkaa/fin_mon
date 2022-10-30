<?php

namespace App\Infrastructure\Adapter;

use TelegramBot\Api\Client;
use TelegramBot\Api\InvalidJsonException;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

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

    public function sendMessage(int $chatId, string $message, ReplyKeyboardMarkup $keyboardMarkup = null): void
    {
        $this->client->sendMessage(
            $chatId,
            $message,
            null,
            false,
            null,
            $keyboardMarkup,
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

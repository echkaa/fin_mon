<?php

namespace App\Domain\Contract\Handler;

interface TelegramHandlerInterface
{
    public function getButtonText(): string;

    public function execute(int $telegramChatId): void;
}

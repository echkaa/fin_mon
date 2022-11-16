<?php

namespace App\Application\Command\Telegram\SendMessage;

use App\Application\Command\AbstractCommand;
use App\Domain\Contract\Command\SyncCommandInterface;

class SendMessageCommand extends AbstractCommand implements SyncCommandInterface
{
    private string $message;
    private int $telegramChatId;

    public function getTelegramChatId(): int
    {
        return $this->telegramChatId;
    }

    public function setTelegramChatId(int $telegramChatId): self
    {
        $this->telegramChatId = $telegramChatId;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}

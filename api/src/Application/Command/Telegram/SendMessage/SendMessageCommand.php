<?php

namespace App\Application\Command\Telegram\SendMessage;

use App\Application\Command\AbstractCommand;
use App\Domain\Contract\Command\AsyncCommandInterface;

class SendMessageCommand extends AbstractCommand implements AsyncCommandInterface
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

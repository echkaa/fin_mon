<?php

namespace App\Application\Service;

use App\Domain\Entity\User;
use App\Infrastructure\Adapter\TelegramAdapter;
use App\Infrastructure\Persistence\MySQL\Repository\UserRepository;
use TelegramBot\Api\InvalidJsonException;
use TelegramBot\Api\Types\Update;

class TelegramService
{
    public function __construct(
        private TelegramAdapter $adapter,
        private UserRepository $userRepository,
    ) {
    }

    /**
     * @throws InvalidJsonException
     */
    public function setHandlers(): void
    {
        $this->adapter->setCommand('start', function ($message) {
            $this->adapter->sendMessage($message->getChat()->getId(), 'Enter your login: ');
        });

        $this->adapter->setOn(function (Update $update) {
            $message = $update->getMessage();
            $id = (int)$message->getChat()->getId();

            $user = $this->userRepository->getByUsername($message->getText());

            if ($user === null) {
                $this->adapter->sendMessage($id, "Invalid username");
                $this->adapter->sendMessage($id, "Enter your login: ");

                return;
            }

            $this->saveChatId($user, $id);

            $this->adapter->sendMessage($id, "Success");
        });

        $this->adapter->run();
    }

    private function saveChatId(User $user, int $chatId): void
    {
        $user->setTelegramChatId($chatId);

        $this->userRepository->update($user);
    }
}

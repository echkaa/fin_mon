<?php

namespace App\Application\Service;

use App\Domain\Contract\Handler\TelegramHandlerInterface;
use App\Domain\Entity\User;
use App\Infrastructure\Adapter\TelegramAdapter;
use App\Infrastructure\Persistence\MySQL\Repository\UserRepository;
use TelegramBot\Api\InvalidJsonException;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;
use TelegramBot\Api\Types\Update;

class TelegramService
{
    public function __construct(
        private array $telegramHandlers,
        private TelegramAdapter $adapter,
        private UserRepository $userRepository,
        private UserService $userService,
    ) {
    }

    /**
     * @throws InvalidJsonException
     */
    public function setEvents(): void
    {
        $this->adapter->setCommand('start', function ($message) {
            $this->adapter->sendMessage($message->getChat()->getId(), 'Enter your login: ');
        });

        $this->adapter->setOn(function (Update $update) {
            $message = $update->getMessage();
            $chatId = (int)$message->getChat()->getId();

            $user = $this->userRepository->getByTelegramChatId($chatId);

            if ($user === null && $user = $this->checkUserRelation($chatId, $message->getText())) {
                $this->saveUserRelation($user, $chatId);
            }

            if ($user) {
                $this->handlerMessage($user, $chatId, $message->getText());
            }
        });

        $this->adapter->run();
    }

    private function checkUserRelation(int $chatId, string $username): ?User
    {
        $user = $this->userRepository->getByUsername($username);

        if ($user === null) {
            $this->sendAuthText($chatId);
        }

        return $user;
    }

    private function sendAuthText(int $chatId): void
    {
        $this->adapter->sendMessage($chatId, "Invalid username");
        $this->adapter->sendMessage($chatId, "Enter your login: ");
    }

    private function saveUserRelation(User $user, int $chatId): void
    {
        $user->setTelegramChatId($chatId);

        $this->userRepository->update($user);
    }

    private function handlerMessage(User $user, int $chatId, string $message): void
    {
        $this->userService->setUser($user);

        if ($handler = $this->findHandler($message)) {
            $handler->execute($chatId);
        }

        $this->userService->getCurrentUser()
            ? $this->showButtons($chatId)
            : $this->sendAuthText($chatId);
    }

    private function findHandler(string $message): ?TelegramHandlerInterface
    {
        /* @var TelegramHandlerInterface $handler */
        foreach ($this->telegramHandlers as $handler) {
            if ($handler->getButtonText() === mb_strtolower($message)) {
                return $handler;
            }
        }

        return null;
    }

    private function showButtons(int $chatId): void
    {
        $buttonList = array_map(
            function (TelegramHandlerInterface $handler) {
                return [
                    'text' => mb_convert_case($handler->getButtonText(), MB_CASE_TITLE),
                ];
            },
            $this->telegramHandlers
        );

        $keyBoard = new ReplyKeyboardMarkup([$buttonList]);

        $this->adapter->sendMessage(
            $chatId,
            'Select option:',
            $keyBoard
        );
    }
}

<?php

namespace App\Application\TelegramHandler;

use App\Application\Service\UserService;
use App\Domain\Contract\Repository\UserRepositoryInterface;
use App\Domain\Contract\Handler\TelegramHandlerInterface;

class RemoveUserRelationHandler implements TelegramHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserService $userService,
    ) {
    }

    public function getButtonText(): string
    {
        return 'remove login';
    }

    public function execute(int $telegramChatId): void
    {
        $user = $this->userService->getCurrentUser();

        $user->setTelegramChatId(null);

        $this->userRepository->update($user);

        $this->userService->setUser(null);
    }
}

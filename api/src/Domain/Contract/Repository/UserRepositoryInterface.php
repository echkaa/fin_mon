<?php

namespace App\Domain\Contract\Repository;

use App\Domain\Entity\User;

interface UserRepositoryInterface extends AbstractRepositoryInterface
{
    public function getByUsername(string $username): ?User;

    public function getByTelegramChatId(int $chatId): ?User;

    public function getTelegramChatIdNotNullList(): array;
}

<?php

namespace App\Domain\Contract\Repository;

use App\Domain\Entity\User;

interface UserRepositoryInterface extends AbstractRepositoryInterface
{
    function getByUsername(string $username): ?User;

    function getByTelegramChatId(int $chatId): ?User;
}

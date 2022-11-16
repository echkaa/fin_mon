<?php

namespace App\Application\Command\Binance\FillUserWallet;

use App\Application\Command\AbstractCommand;
use App\Domain\Contract\Command\AsyncCommandInterface;

class FillUserWalletCommand extends AbstractCommand implements AsyncCommandInterface
{
    private int $userId;

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}

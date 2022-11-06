<?php

namespace App\Application\Command\Binance\FillUserWallet;

use App\Application\Command\AbstractCommand;

class BinanceFillUserWalletCommand extends AbstractCommand
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

<?php

namespace App\Domain\Contract\Factory;

use App\Domain\Entity\Coin;

interface CoinFactoryInterface
{
    public function getInstance(): Coin;

    public function fillEntityFromBinance(Coin $entity, array $data): Coin;
}

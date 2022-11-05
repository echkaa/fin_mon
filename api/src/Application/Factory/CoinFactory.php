<?php

namespace App\Application\Factory;

use App\Domain\Contract\Factory\CoinFactoryInterface;
use App\Domain\Entity\Coin;

class CoinFactory implements CoinFactoryInterface
{
    public function getInstance(): Coin
    {
        return new Coin();
    }

    public function fillEntityFromBinance(Coin $entity, array $data): Coin
    {
        return $entity->setName($data['assetName'])
            ->setFullName($data['assetFullName'] ?? null);
    }
}

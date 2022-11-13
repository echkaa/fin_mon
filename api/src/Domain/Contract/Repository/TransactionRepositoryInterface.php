<?php

namespace App\Domain\Contract\Repository;

use App\Domain\Entity\Coin;
use App\Domain\Entity\Transaction;
use App\Domain\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

interface TransactionRepositoryInterface extends AbstractRepositoryInterface
{
    public function getLastTransactionByUser(User $user): ArrayCollection;

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getLastTransactionByCoin(User $user, Coin $coin): ?Transaction;
}

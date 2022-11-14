<?php

namespace App\Infrastructure\Persistence\MySQL\Repository;

use App\Domain\Contract\Repository\TransactionRepositoryInterface;
use App\Domain\Entity\Coin;
use App\Domain\Entity\Transaction;
use App\Domain\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class TransactionRepository extends AbstractRepository implements TransactionRepositoryInterface
{
    function getEntityClassName(): string
    {
        return Transaction::class;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getLastTransactionByCoin(User $user, Coin $coin): ?Transaction
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.coin', 'c')
            ->leftJoin('t.setting', 's')
            ->where('c = :coin')
            ->andWhere('s.user = :user')
            ->setParameters([
                'coin' => $coin,
                'user' => $user,
            ])
            ->orderBy('t.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
    }

    public function getLastTransactionByUser(User $user): ArrayCollection
    {
        $result = $this->createQueryBuilder('t')
            ->select('t')
            ->leftJoin(
                'App\Domain\Entity\Transaction',
                'tt',
                'WITH',
                't.coin = tt.coin AND t.id < tt.id'
            )
            ->leftJoin('t.coin', 'c')
            ->leftJoin('t.setting', 's')
            ->where('s.user = :user')
            ->andWhere('tt.id is null')
            ->setParameter('user', $user)
            ->groupBy('t.coin')
            ->orderBy('t.id', 'DESC')
            ->getQuery()
            ->getResult();

        return new ArrayCollection($result);
    }
}

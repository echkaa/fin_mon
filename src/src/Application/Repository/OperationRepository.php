<?php

namespace App\Application\Repository;

use App\Domain\Entity\Operation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Operation::class);
    }

    public function getStatistic(): array
    {
        return $this->createQueryBuilder('op')
            ->select([
                'SUM(op.amount) as summa',
                'COUNT(op.id) as count_operation',
            ])
            ->getQuery()
            ->getArrayResult();
    }
}

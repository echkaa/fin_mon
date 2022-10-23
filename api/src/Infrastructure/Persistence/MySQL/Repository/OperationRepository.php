<?php

namespace App\Infrastructure\Persistence\MySQL\Repository;

use App\Application\Service\UserService;
use App\Domain\Contract\Repository\OperationRepositoryInterface;
use App\Domain\Entity\Operation;
use DateTime;
use DateInterval;
use Doctrine\Persistence\ManagerRegistry;

class OperationRepository extends AbstractRepository implements OperationRepositoryInterface
{
    public function __construct(
        private UserService $userService,
        ManagerRegistry $registry,
    ) {
        parent::__construct(
            $registry
        );
    }

    public function getEntityClassName(): string
    {
        return Operation::class;
    }

    public function getStatisticByUser(int $userId): array
    {
        return $this->createQueryBuilder('op')
            ->select([
                'SUM(op.amount) as summa',
                'COUNT(op.id) as count_operation',
            ])
            ->where('op.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getArrayResult();
    }

    public function getExternalIdsFromTime(DateTime $dateTime): array
    {
        return $this->createQueryBuilder('op')
            ->select([
                'op.externalId',
            ])
            ->where("op.date >= :dateTime")
            ->andWhere("op.externalId is not null")
            ->setParameter('dateTime', $dateTime)
            ->getQuery()
            ->getArrayResult();
    }

    public function getByFilters(?array $filters): array
    {
        $query = $this->createQueryBuilder('op')
            ->where('op.archive = false')
            ->andWhere('op.user = :user')
            ->setParameter('user', $this->userService->getCurrentUser());

        if (isset($filters['from'])) {
            $query->andWhere("op.date >= :from")
                ->setParameter('from', new DateTime($filters['from']));
        }

        if (isset($filters['to'])) {
            $query->andWhere("op.date <= :to")
                ->setParameter(
                    key: 'to',
                    value: (new DateTime($filters['to']))->add(new DateInterval('P1D'))
                );
        }

        return $query->getQuery()
            ->getResult();
    }
}

<?php

namespace App\Infrastructure\Persistence\MySQL\Repository;

use App\Domain\Contract\Entity\EntityInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

abstract class AbstractRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct(
            $registry,
            $this->getEntityClassName(),
        );
    }

    abstract function getEntityClassName(): string;

    function store(EntityInterface $entity): void
    {
        $this->_em->persist($entity);

        $this->_em->flush();
    }

    function all(): array
    {
        return $this->findAll();
    }

    function update(EntityInterface $entity): void
    {
        $this->_em->flush();
    }

    function delete(EntityInterface $entity): void
    {
        $this->_em->remove($entity);

        $this->_em->flush();
    }

    /**
     * @throws Exception
     */
    function findByOne(int $id): ?EntityInterface
    {
        $entity = $this->find($id);

        if ($entity === null) {
            throw new Exception("Not found entity by ID");
        }

        return $entity;
    }
}

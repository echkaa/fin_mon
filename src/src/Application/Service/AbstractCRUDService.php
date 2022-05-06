<?php

namespace App\Application\Service;

use App\Domain\Contract\Entity\EntityInterface;
use App\Domain\Contract\Service\CRUDOperationService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Exception;

abstract class AbstractCRUDService implements CRUDOperationService
{
    private ObjectManager $entityManager;

    public function __construct(
        private ServiceEntityRepository $entityRepository,
        ManagerRegistry $doctrine,
    ) {
        $this->entityManager = $doctrine->getManager();
    }

    function store(EntityInterface $entity): void
    {
        $this->entityManager->persist($entity);

        $this->entityManager->flush();
    }

    function all(): array
    {
        return $this->entityRepository->findAll();
    }

    function update(EntityInterface $entity): void
    {
        $this->entityManager->flush();
    }

    function delete(int $id): void
    {
        $entity = $this->findById($id);

        $this->entityManager->remove($entity);

        $this->entityManager->flush();
    }

    /**
     * @throws Exception
     */
    function findById(int $id): ?EntityInterface
    {
        $entity = $this->entityRepository->find($id);

        if ($entity === null) {
            throw new Exception("Not found entity by ID");
        }

        return $entity;
    }
}

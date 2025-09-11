<?php

namespace Infrastructure\Doctrine\Repositories;

use Application\Repositories\SettingsRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Infrastructure\Doctrine\Models\DoctrineSettingsEntity;

class DoctrineSettingsRepository extends DoctrineRepository implements SettingsRepositoryInterface
{
    private readonly EntityRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);

        $this->repository = $this->getEntityManager()->getRepository(DoctrineSettingsEntity::class);
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }
}
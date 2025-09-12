<?php

namespace Infrastructure\Doctrine\Repositories;

use Application\Repositories\SettingsRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Infrastructure\Doctrine\Models\DoctrineSettingsModel;

class DoctrineSettingsRepository extends DoctrineRepository implements SettingsRepositoryInterface
{
    private readonly EntityRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);

        $this->repository = $this->getEntityManager()->getRepository(DoctrineSettingsModel::class);
    }

    public function getAll(): array
    {
        $models = $this->repository->findAll();

        return array_map(fn($model) => $model->toDomain(), $models);
    }
}
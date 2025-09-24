<?php

namespace Infrastructure\Doctrine\Repositories;

use Application\Exceptions\PersistenceFailedException;
use Application\Repositories\SettingsRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
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

    /**
     * @throws PersistenceFailedException when persistence fails
     */
    public function update(array $settings): void
    {
        try {
            foreach ($settings as $setting) {
                $model = $this->repository->findOneBy([
                    'key' => $setting->getKey()
                ]);
                if (!$model)
                    continue;

                $model->value = $setting->getValue();
                $this->getEntityManager()->persist($model);
            }
        } catch (ORMException $e) {
            throw new PersistenceFailedException();
        }
    }
}
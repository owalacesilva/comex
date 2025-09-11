<?php

namespace Infrastructure\Doctrine\Repositories;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Abstract class representing a repository base that integrates with Doctrine's entity manager,
 * providing access to perform database operations on entities.
 */
abstract class DoctrineRepository
{
    private readonly EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}
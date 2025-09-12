<?php

namespace Domain\Entities;

/**
 * Represents an abstract base class for an entity with a unique identifier.
 */
abstract class Entity
{
    protected null|string|int $id;

    public function __construct(null|string|int $id) {
        $this->id = $id;
    }

    public function getId(): null|string|int {
        return $this->id;
    }

    public function setId(null|string|int $id): void {
        $this->id = $id;
    }
}
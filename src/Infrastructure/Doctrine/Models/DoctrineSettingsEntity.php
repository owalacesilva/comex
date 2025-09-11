<?php

namespace Infrastructure\Doctrine\Models;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\Entity]
#[ORM\Table(name: 'settings')]
class DoctrineSettingsEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer')]
    public int $id;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    public DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime')]
    public DateTime $updatedAt;

    #[ORM\Column(name: 'key', type: 'string', length: 255)]
    public string $key;

    #[ORM\Column(name: 'value', type: 'string', length: 255)]
    public string $value;

    #[ORM\Column(name: 'description', type: 'string')]
    public string $description;
}
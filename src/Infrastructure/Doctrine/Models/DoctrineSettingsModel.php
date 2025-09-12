<?php

namespace Infrastructure\Doctrine\Models;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Domain\Entities\SettingEntity;

#[ORM\Entity]
#[ORM\Table(name: 'settings')]
class DoctrineSettingsModel
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

    public function toDomain(): SettingEntity
    {
        $entity = new SettingEntity($this->id);
        $entity->createdAt = $this->createdAt;
        $entity->setUpdatedAt($this->updatedAt);
        $entity->setKey($this->key);
        $entity->setValue($this->value);
        $entity->setDescription($this->description);;

        return $entity;
    }
}
<?php

namespace Infrastructure\Doctrine\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Infrastructure\Doctrine\Models\DoctrineSettingsModel;
use DateTime;

class SettingsDataLoader implements FixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create();

        $model = new DoctrineSettingsModel();
        $model->createdAt = new DateTime();
        $model->updatedAt = new DateTime();
        $model->key = $faker->word();
        $model->value = $faker->colorName();
        $model->description = $faker->paragraphs(1, true);

        $manager->persist($model);
        $manager->flush();
    }
}
<?php

declare(strict_types=1);

namespace Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\PrimaryKeyConstraint;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250903032345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create settings table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('settings');

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('created_at', 'datetime', ['notnull' => true, 'default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetime', ['notnull' => false]);
        $table->addColumn('key', 'string', ['length' => 255]);
        $table->addColumn('value', 'string', ['length' => 255]);
        $table->addColumn('description', 'text');
        $table->addPrimaryKeyConstraint(
            PrimaryKeyConstraint::editor()
                ->setUnquotedColumnNames('id')
                ->create()
        );
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('settings');
    }
}

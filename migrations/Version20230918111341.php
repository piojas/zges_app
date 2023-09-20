<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230918111341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__task AS SELECT id, title, description, start, stop, created_at, updated_at FROM task');
        $this->addSql('DROP TABLE task');
        $this->addSql('CREATE TABLE task (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(100) NOT NULL, description CLOB DEFAULT NULL, start DATETIME DEFAULT NULL, stop DATETIME DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO task (id, title, description, start, stop, created_at, updated_at) SELECT id, title, description, start, stop, created_at, updated_at FROM __temp__task');
        $this->addSql('DROP TABLE __temp__task');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__task AS SELECT id, title, description, start, stop, created_at, updated_at FROM task');
        $this->addSql('DROP TABLE task');
        $this->addSql('CREATE TABLE task (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(100) NOT NULL, description CLOB DEFAULT NULL, start DATETIME NOT NULL, stop DATETIME DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO task (id, title, description, start, stop, created_at, updated_at) SELECT id, title, description, start, stop, created_at, updated_at FROM __temp__task');
        $this->addSql('DROP TABLE __temp__task');
    }
}

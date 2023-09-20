<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230918101255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL)');
        $this->addSql('CREATE TABLE tag_task (tag_id INTEGER NOT NULL, task_id INTEGER NOT NULL, PRIMARY KEY(tag_id, task_id), CONSTRAINT FK_BC716493BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_BC7164938DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_BC716493BAD26311 ON tag_task (tag_id)');
        $this->addSql('CREATE INDEX IDX_BC7164938DB60186 ON tag_task (task_id)');
        $this->addSql('CREATE TABLE task_tag (task_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(task_id, tag_id), CONSTRAINT FK_6C0B4F048DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6C0B4F04BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_6C0B4F048DB60186 ON task_tag (task_id)');
        $this->addSql('CREATE INDEX IDX_6C0B4F04BAD26311 ON task_tag (tag_id)');
        $this->addSql('DROP TABLE todo');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE todo (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(200) NOT NULL COLLATE "BINARY")');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_task');
        $this->addSql('DROP TABLE task_tag');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190604222602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_32993751115F0EE5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__score AS SELECT id, domain_id, score FROM score');
        $this->addSql('DROP TABLE score');
        $this->addSql('CREATE TABLE score (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, domain_id INTEGER NOT NULL, score DOUBLE PRECISION NOT NULL, date DATETIME NOT NULL, CONSTRAINT FK_32993751115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO score (id, domain_id, score) SELECT id, domain_id, score FROM __temp__score');
        $this->addSql('DROP TABLE __temp__score');
        $this->addSql('CREATE INDEX IDX_32993751115F0EE5 ON score (domain_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_32993751115F0EE5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__score AS SELECT id, domain_id, score FROM score');
        $this->addSql('DROP TABLE score');
        $this->addSql('CREATE TABLE score (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, domain_id INTEGER NOT NULL, score DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO score (id, domain_id, score) SELECT id, domain_id, score FROM __temp__score');
        $this->addSql('DROP TABLE __temp__score');
        $this->addSql('CREATE INDEX IDX_32993751115F0EE5 ON score (domain_id)');
    }
}

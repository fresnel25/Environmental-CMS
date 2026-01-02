<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251221154421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bloc ADD media_id INT DEFAULT NULL, DROP titre');
        $this->addSql('ALTER TABLE bloc ADD CONSTRAINT FK_C778955AEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('CREATE INDEX IDX_C778955AEA9FDD75 ON bloc (media_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bloc DROP FOREIGN KEY FK_C778955AEA9FDD75');
        $this->addSql('DROP INDEX IDX_C778955AEA9FDD75 ON bloc');
        $this->addSql('ALTER TABLE bloc ADD titre VARCHAR(255) NOT NULL, DROP media_id');
    }
}

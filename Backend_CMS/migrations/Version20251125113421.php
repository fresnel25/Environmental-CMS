<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251125113421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bloc ADD article_id INT NOT NULL, ADD visualisation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bloc ADD CONSTRAINT FK_C778955A7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE bloc ADD CONSTRAINT FK_C778955A1A36181E FOREIGN KEY (visualisation_id) REFERENCES visualisation (id)');
        $this->addSql('CREATE INDEX IDX_C778955A7294869C ON bloc (article_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C778955A1A36181E ON bloc (visualisation_id)');
        $this->addSql('ALTER TABLE colonne_dataset ADD dataset_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE colonne_dataset ADD CONSTRAINT FK_EDE4B5ACD47C2D1B FOREIGN KEY (dataset_id) REFERENCES dataset (id)');
        $this->addSql('CREATE INDEX IDX_EDE4B5ACD47C2D1B ON colonne_dataset (dataset_id)');
        $this->addSql('ALTER TABLE note ADD bloc_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA145582E9C0 FOREIGN KEY (bloc_id) REFERENCES bloc (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA145582E9C0 ON note (bloc_id)');
        $this->addSql('ALTER TABLE visualisation ADD dataset_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE visualisation ADD CONSTRAINT FK_C79C3D88D47C2D1B FOREIGN KEY (dataset_id) REFERENCES dataset (id)');
        $this->addSql('CREATE INDEX IDX_C79C3D88D47C2D1B ON visualisation (dataset_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE colonne_dataset DROP FOREIGN KEY FK_EDE4B5ACD47C2D1B');
        $this->addSql('DROP INDEX IDX_EDE4B5ACD47C2D1B ON colonne_dataset');
        $this->addSql('ALTER TABLE colonne_dataset DROP dataset_id');
        $this->addSql('ALTER TABLE visualisation DROP FOREIGN KEY FK_C79C3D88D47C2D1B');
        $this->addSql('DROP INDEX IDX_C79C3D88D47C2D1B ON visualisation');
        $this->addSql('ALTER TABLE visualisation DROP dataset_id');
        $this->addSql('ALTER TABLE bloc DROP FOREIGN KEY FK_C778955A7294869C');
        $this->addSql('ALTER TABLE bloc DROP FOREIGN KEY FK_C778955A1A36181E');
        $this->addSql('DROP INDEX IDX_C778955A7294869C ON bloc');
        $this->addSql('DROP INDEX UNIQ_C778955A1A36181E ON bloc');
        $this->addSql('ALTER TABLE bloc DROP article_id, DROP visualisation_id');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA145582E9C0');
        $this->addSql('DROP INDEX IDX_CFBDFA145582E9C0 ON note');
        $this->addSql('ALTER TABLE note DROP bloc_id');
    }
}

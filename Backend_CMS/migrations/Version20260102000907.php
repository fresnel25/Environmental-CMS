<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260102000907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visualisation DROP FOREIGN KEY FK_C79C3D88D47C2D1B');
        $this->addSql('ALTER TABLE visualisation CHANGE dataset_id dataset_id INT NOT NULL');
        $this->addSql('ALTER TABLE visualisation ADD CONSTRAINT FK_C79C3D88D47C2D1B FOREIGN KEY (dataset_id) REFERENCES dataset (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visualisation DROP FOREIGN KEY FK_C79C3D88D47C2D1B');
        $this->addSql('ALTER TABLE visualisation CHANGE dataset_id dataset_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE visualisation ADD CONSTRAINT FK_C79C3D88D47C2D1B FOREIGN KEY (dataset_id) REFERENCES dataset (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}

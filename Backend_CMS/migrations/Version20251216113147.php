<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251216113147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, tenant_id INT NOT NULL, created_by_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', titre VARCHAR(255) NOT NULL, resume LONGTEXT NOT NULL, status TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL, INDEX IDX_23A0E669033212A (tenant_id), INDEX IDX_23A0E66B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bloc (id INT AUTO_INCREMENT NOT NULL, tenant_id INT NOT NULL, created_by_id INT NOT NULL, article_id INT NOT NULL, visualisation_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', type_bloc VARCHAR(255) NOT NULL, position INT NOT NULL, titre VARCHAR(255) NOT NULL, contenu_json JSON NOT NULL, INDEX IDX_C778955A9033212A (tenant_id), INDEX IDX_C778955AB03A8386 (created_by_id), INDEX IDX_C778955A7294869C (article_id), UNIQUE INDEX UNIQ_C778955A1A36181E (visualisation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE colonne_dataset (id INT AUTO_INCREMENT NOT NULL, tenant_id INT NOT NULL, created_by_id INT NOT NULL, dataset_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', nom_colonne VARCHAR(255) NOT NULL, type_colonne VARCHAR(255) NOT NULL, INDEX IDX_EDE4B5AC9033212A (tenant_id), INDEX IDX_EDE4B5ACB03A8386 (created_by_id), INDEX IDX_EDE4B5ACD47C2D1B (dataset_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dataset (id INT AUTO_INCREMENT NOT NULL, tenant_id INT NOT NULL, created_by_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, type_source VARCHAR(255) NOT NULL, url_source VARCHAR(255) NOT NULL, delimiter VARCHAR(5) DEFAULT \';\' NOT NULL, INDEX IDX_B7A041D09033212A (tenant_id), INDEX IDX_B7A041D0B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, tenant_id INT NOT NULL, created_by_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', lien LONGTEXT NOT NULL, type_img VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, INDEX IDX_6A2CA10C9033212A (tenant_id), INDEX IDX_6A2CA10CB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, tenant_id INT NOT NULL, created_by_id INT NOT NULL, bloc_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', valeur INT DEFAULT NULL, INDEX IDX_CFBDFA149033212A (tenant_id), INDEX IDX_CFBDFA14B03A8386 (created_by_id), INDEX IDX_CFBDFA145582E9C0 (bloc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plan (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', nom VARCHAR(255) NOT NULL, prix INT NOT NULL, limite JSON NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tenant (id INT AUTO_INCREMENT NOT NULL, plan_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', nom VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, INDEX IDX_4E59C462E899029B (plan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, tenant_id INT NOT NULL, created_by_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', nom_theme VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, variable_css JSON NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_9775E7089033212A (tenant_id), INDEX IDX_9775E708B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, tenant_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, statut TINYINT(1) DEFAULT NULL, telephone VARCHAR(255) NOT NULL, INDEX IDX_8D93D6499033212A (tenant_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visualisation (id INT AUTO_INCREMENT NOT NULL, tenant_id INT NOT NULL, created_by_id INT NOT NULL, dataset_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', type_visualisation VARCHAR(255) NOT NULL, correspondance_json JSON NOT NULL, style_json JSON DEFAULT NULL, filter_json JSON DEFAULT NULL, note LONGTEXT NOT NULL, INDEX IDX_C79C3D889033212A (tenant_id), INDEX IDX_C79C3D88B03A8386 (created_by_id), INDEX IDX_C79C3D88D47C2D1B (dataset_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E669033212A FOREIGN KEY (tenant_id) REFERENCES tenant (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE bloc ADD CONSTRAINT FK_C778955A9033212A FOREIGN KEY (tenant_id) REFERENCES tenant (id)');
        $this->addSql('ALTER TABLE bloc ADD CONSTRAINT FK_C778955AB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE bloc ADD CONSTRAINT FK_C778955A7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE bloc ADD CONSTRAINT FK_C778955A1A36181E FOREIGN KEY (visualisation_id) REFERENCES visualisation (id)');
        $this->addSql('ALTER TABLE colonne_dataset ADD CONSTRAINT FK_EDE4B5AC9033212A FOREIGN KEY (tenant_id) REFERENCES tenant (id)');
        $this->addSql('ALTER TABLE colonne_dataset ADD CONSTRAINT FK_EDE4B5ACB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE colonne_dataset ADD CONSTRAINT FK_EDE4B5ACD47C2D1B FOREIGN KEY (dataset_id) REFERENCES dataset (id)');
        $this->addSql('ALTER TABLE dataset ADD CONSTRAINT FK_B7A041D09033212A FOREIGN KEY (tenant_id) REFERENCES tenant (id)');
        $this->addSql('ALTER TABLE dataset ADD CONSTRAINT FK_B7A041D0B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C9033212A FOREIGN KEY (tenant_id) REFERENCES tenant (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA149033212A FOREIGN KEY (tenant_id) REFERENCES tenant (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA145582E9C0 FOREIGN KEY (bloc_id) REFERENCES bloc (id)');
        $this->addSql('ALTER TABLE tenant ADD CONSTRAINT FK_4E59C462E899029B FOREIGN KEY (plan_id) REFERENCES plan (id)');
        $this->addSql('ALTER TABLE theme ADD CONSTRAINT FK_9775E7089033212A FOREIGN KEY (tenant_id) REFERENCES tenant (id)');
        $this->addSql('ALTER TABLE theme ADD CONSTRAINT FK_9775E708B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499033212A FOREIGN KEY (tenant_id) REFERENCES tenant (id)');
        $this->addSql('ALTER TABLE visualisation ADD CONSTRAINT FK_C79C3D889033212A FOREIGN KEY (tenant_id) REFERENCES tenant (id)');
        $this->addSql('ALTER TABLE visualisation ADD CONSTRAINT FK_C79C3D88B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE visualisation ADD CONSTRAINT FK_C79C3D88D47C2D1B FOREIGN KEY (dataset_id) REFERENCES dataset (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E669033212A');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66B03A8386');
        $this->addSql('ALTER TABLE bloc DROP FOREIGN KEY FK_C778955A9033212A');
        $this->addSql('ALTER TABLE bloc DROP FOREIGN KEY FK_C778955AB03A8386');
        $this->addSql('ALTER TABLE bloc DROP FOREIGN KEY FK_C778955A7294869C');
        $this->addSql('ALTER TABLE bloc DROP FOREIGN KEY FK_C778955A1A36181E');
        $this->addSql('ALTER TABLE colonne_dataset DROP FOREIGN KEY FK_EDE4B5AC9033212A');
        $this->addSql('ALTER TABLE colonne_dataset DROP FOREIGN KEY FK_EDE4B5ACB03A8386');
        $this->addSql('ALTER TABLE colonne_dataset DROP FOREIGN KEY FK_EDE4B5ACD47C2D1B');
        $this->addSql('ALTER TABLE dataset DROP FOREIGN KEY FK_B7A041D09033212A');
        $this->addSql('ALTER TABLE dataset DROP FOREIGN KEY FK_B7A041D0B03A8386');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C9033212A');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CB03A8386');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA149033212A');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14B03A8386');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA145582E9C0');
        $this->addSql('ALTER TABLE tenant DROP FOREIGN KEY FK_4E59C462E899029B');
        $this->addSql('ALTER TABLE theme DROP FOREIGN KEY FK_9775E7089033212A');
        $this->addSql('ALTER TABLE theme DROP FOREIGN KEY FK_9775E708B03A8386');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499033212A');
        $this->addSql('ALTER TABLE visualisation DROP FOREIGN KEY FK_C79C3D889033212A');
        $this->addSql('ALTER TABLE visualisation DROP FOREIGN KEY FK_C79C3D88B03A8386');
        $this->addSql('ALTER TABLE visualisation DROP FOREIGN KEY FK_C79C3D88D47C2D1B');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE bloc');
        $this->addSql('DROP TABLE colonne_dataset');
        $this->addSql('DROP TABLE dataset');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE plan');
        $this->addSql('DROP TABLE tenant');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE visualisation');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

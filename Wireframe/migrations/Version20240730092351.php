<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240730092351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annual_leave (id VARCHAR(36) NOT NULL, worker_id VARCHAR(36) NOT NULL, year INT NOT NULL, total_days INT NOT NULL, month VARCHAR(20) NOT NULL, INDEX IDX_4F87A2346B20BA36 (worker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE request_for_al (id VARCHAR(36) NOT NULL, worker_id VARCHAR(36) NOT NULL, team_leader_id VARCHAR(36) DEFAULT NULL, project_leader_id VARCHAR(36) DEFAULT NULL, start DATE NOT NULL, end DATE NOT NULL, reason VARCHAR(255) DEFAULT NULL, date_of_processing DATE NOT NULL, INDEX IDX_A160188C6B20BA36 (worker_id), INDEX IDX_A160188CC4105033 (team_leader_id), INDEX IDX_A160188C62290B03 (project_leader_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id VARCHAR(36) NOT NULL, name VARCHAR(40) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_leaders (id VARCHAR(36) NOT NULL, team_id VARCHAR(36) NOT NULL, project_leader_id VARCHAR(36) NOT NULL, team_lead_id VARCHAR(36) NOT NULL, INDEX IDX_FC351AA1296CD8AE (team_id), INDEX IDX_FC351AA162290B03 (project_leader_id), INDEX IDX_FC351AA1FF2C34BA (team_lead_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id VARCHAR(36) NOT NULL, team_id VARCHAR(36) DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, INDEX IDX_8D93D649296CD8AE (team_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annual_leave ADD CONSTRAINT FK_4F87A2346B20BA36 FOREIGN KEY (worker_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE request_for_al ADD CONSTRAINT FK_A160188C6B20BA36 FOREIGN KEY (worker_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE request_for_al ADD CONSTRAINT FK_A160188CC4105033 FOREIGN KEY (team_leader_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE request_for_al ADD CONSTRAINT FK_A160188C62290B03 FOREIGN KEY (project_leader_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE team_leaders ADD CONSTRAINT FK_FC351AA1296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE team_leaders ADD CONSTRAINT FK_FC351AA162290B03 FOREIGN KEY (project_leader_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE team_leaders ADD CONSTRAINT FK_FC351AA1FF2C34BA FOREIGN KEY (team_lead_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annual_leave DROP FOREIGN KEY FK_4F87A2346B20BA36');
        $this->addSql('ALTER TABLE request_for_al DROP FOREIGN KEY FK_A160188C6B20BA36');
        $this->addSql('ALTER TABLE request_for_al DROP FOREIGN KEY FK_A160188CC4105033');
        $this->addSql('ALTER TABLE request_for_al DROP FOREIGN KEY FK_A160188C62290B03');
        $this->addSql('ALTER TABLE team_leaders DROP FOREIGN KEY FK_FC351AA1296CD8AE');
        $this->addSql('ALTER TABLE team_leaders DROP FOREIGN KEY FK_FC351AA162290B03');
        $this->addSql('ALTER TABLE team_leaders DROP FOREIGN KEY FK_FC351AA1FF2C34BA');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649296CD8AE');
        $this->addSql('DROP TABLE annual_leave');
        $this->addSql('DROP TABLE request_for_al');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE team_leaders');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

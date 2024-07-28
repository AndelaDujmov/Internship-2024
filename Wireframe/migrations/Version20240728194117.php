<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240728194117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annual_leave (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', worker_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', year INT NOT NULL, total_days INT NOT NULL, month VARCHAR(20) NOT NULL, INDEX IDX_4F87A2346B20BA36 (worker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE leader (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE request_for_al (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', worker_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', team_lead_approve_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', project_lead_approveal_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', start DATE NOT NULL, end DATE NOT NULL, reason VARCHAR(255) DEFAULT NULL, date_of_processing DATE NOT NULL, INDEX IDX_A160188C6B20BA36 (worker_id), INDEX IDX_A160188CEBA6266E (team_lead_approve_id), INDEX IDX_A160188CEFB661E5 (project_lead_approveal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(40) NOT NULL, member_number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_leaders (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', project_leader_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', team_leader_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', team_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_FC351AA162290B03 (project_leader_id), INDEX IDX_FC351AA1C4105033 (team_leader_id), INDEX IDX_FC351AA1296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE worker (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', team_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(15) NOT NULL, surname VARCHAR(40) NOT NULL, INDEX IDX_9FB2BF62296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annual_leave ADD CONSTRAINT FK_4F87A2346B20BA36 FOREIGN KEY (worker_id) REFERENCES worker (id)');
        $this->addSql('ALTER TABLE request_for_al ADD CONSTRAINT FK_A160188C6B20BA36 FOREIGN KEY (worker_id) REFERENCES worker (id)');
        $this->addSql('ALTER TABLE request_for_al ADD CONSTRAINT FK_A160188CEBA6266E FOREIGN KEY (team_lead_approve_id) REFERENCES leader (id)');
        $this->addSql('ALTER TABLE request_for_al ADD CONSTRAINT FK_A160188CEFB661E5 FOREIGN KEY (project_lead_approveal_id) REFERENCES leader (id)');
        $this->addSql('ALTER TABLE team_leaders ADD CONSTRAINT FK_FC351AA162290B03 FOREIGN KEY (project_leader_id) REFERENCES leader (id)');
        $this->addSql('ALTER TABLE team_leaders ADD CONSTRAINT FK_FC351AA1C4105033 FOREIGN KEY (team_leader_id) REFERENCES leader (id)');
        $this->addSql('ALTER TABLE team_leaders ADD CONSTRAINT FK_FC351AA1296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE worker ADD CONSTRAINT FK_9FB2BF62296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annual_leave DROP FOREIGN KEY FK_4F87A2346B20BA36');
        $this->addSql('ALTER TABLE request_for_al DROP FOREIGN KEY FK_A160188C6B20BA36');
        $this->addSql('ALTER TABLE request_for_al DROP FOREIGN KEY FK_A160188CEBA6266E');
        $this->addSql('ALTER TABLE request_for_al DROP FOREIGN KEY FK_A160188CEFB661E5');
        $this->addSql('ALTER TABLE team_leaders DROP FOREIGN KEY FK_FC351AA162290B03');
        $this->addSql('ALTER TABLE team_leaders DROP FOREIGN KEY FK_FC351AA1C4105033');
        $this->addSql('ALTER TABLE team_leaders DROP FOREIGN KEY FK_FC351AA1296CD8AE');
        $this->addSql('ALTER TABLE worker DROP FOREIGN KEY FK_9FB2BF62296CD8AE');
        $this->addSql('DROP TABLE annual_leave');
        $this->addSql('DROP TABLE leader');
        $this->addSql('DROP TABLE request_for_al');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE team_leaders');
        $this->addSql('DROP TABLE worker');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

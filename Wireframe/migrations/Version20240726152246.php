<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240726152246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annual_leave (id INT AUTO_INCREMENT NOT NULL, worker_id INT NOT NULL, year INT NOT NULL, total_days INT NOT NULL, month VARCHAR(20) NOT NULL, INDEX IDX_4F87A2346B20BA36 (worker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE leader (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE request_for_al (id INT AUTO_INCREMENT NOT NULL, worker_id INT NOT NULL, team_lead_approve_id INT DEFAULT NULL, project_lead_approveal_id INT DEFAULT NULL, start DATE NOT NULL, end DATE NOT NULL, reason VARCHAR(255) DEFAULT NULL, date_of_processing DATE NOT NULL, INDEX IDX_A160188C6B20BA36 (worker_id), INDEX IDX_A160188CEBA6266E (team_lead_approve_id), INDEX IDX_A160188CEFB661E5 (project_lead_approveal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(40) NOT NULL, member_number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_leaders (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE worker (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annual_leave ADD CONSTRAINT FK_4F87A2346B20BA36 FOREIGN KEY (worker_id) REFERENCES worker (id)');
        $this->addSql('ALTER TABLE request_for_al ADD CONSTRAINT FK_A160188C6B20BA36 FOREIGN KEY (worker_id) REFERENCES worker (id)');
        $this->addSql('ALTER TABLE request_for_al ADD CONSTRAINT FK_A160188CEBA6266E FOREIGN KEY (team_lead_approve_id) REFERENCES leader (id)');
        $this->addSql('ALTER TABLE request_for_al ADD CONSTRAINT FK_A160188CEFB661E5 FOREIGN KEY (project_lead_approveal_id) REFERENCES leader (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annual_leave DROP FOREIGN KEY FK_4F87A2346B20BA36');
        $this->addSql('ALTER TABLE request_for_al DROP FOREIGN KEY FK_A160188C6B20BA36');
        $this->addSql('ALTER TABLE request_for_al DROP FOREIGN KEY FK_A160188CEBA6266E');
        $this->addSql('ALTER TABLE request_for_al DROP FOREIGN KEY FK_A160188CEFB661E5');
        $this->addSql('DROP TABLE annual_leave');
        $this->addSql('DROP TABLE leader');
        $this->addSql('DROP TABLE request_for_al');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE team_leaders');
        $this->addSql('DROP TABLE worker');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

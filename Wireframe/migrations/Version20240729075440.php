<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240729075440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annual_leave DROP FOREIGN KEY FK_4F87A234A76ED395');
        $this->addSql('DROP INDEX IDX_4F87A234A76ED395 ON annual_leave');
        $this->addSql('ALTER TABLE annual_leave CHANGE user_id worker_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE annual_leave ADD CONSTRAINT FK_4F87A2346B20BA36 FOREIGN KEY (worker_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4F87A2346B20BA36 ON annual_leave (worker_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annual_leave DROP FOREIGN KEY FK_4F87A2346B20BA36');
        $this->addSql('DROP INDEX IDX_4F87A2346B20BA36 ON annual_leave');
        $this->addSql('ALTER TABLE annual_leave CHANGE worker_id user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE annual_leave ADD CONSTRAINT FK_4F87A234A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_4F87A234A76ED395 ON annual_leave (user_id)');
    }
}

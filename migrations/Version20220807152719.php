<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220807152719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE iconographique ADD created_at DATETIME NOT NULL DEFAULT NOW()');
        $this->addSql('ALTER TABLE magazine DROP created_at');
        $this->addSql('ALTER TABLE pigiste_client ADD created_at DATETIME NOT NULL DEFAULT NOW()');
        $this->addSql('ALTER TABLE redachef ADD created_at DATETIME NOT NULL DEFAULT NOW()');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE iconographique DROP created_at');
        $this->addSql('ALTER TABLE magazine ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE pigiste_client DROP created_at');
        $this->addSql('ALTER TABLE redachef DROP created_at');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220809085658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE iconographique CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE magazine ADD nb_de_page_redactionnelle_set_at DATETIME DEFAULT NULL DEFAULT NOW()');
        $this->addSql('ALTER TABLE pigiste_client CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE redachef CHANGE created_at created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE iconographique CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE magazine DROP nb_de_page_redactionnelle_set_at');
        $this->addSql('ALTER TABLE pigiste_client CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE redachef CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}

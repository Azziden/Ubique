<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628100534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salarie_et_entreprise CHANGE statut statut VARCHAR(63) DEFAULT NULL, CHANGE type type VARCHAR(63) DEFAULT NULL, CHANGE abattement_30 abattement_30 VARCHAR(63) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salarie_et_entreprise CHANGE statut statut VARCHAR(63) NOT NULL, CHANGE type type VARCHAR(63) NOT NULL, CHANGE abattement_30 abattement_30 VARCHAR(63) NOT NULL');
    }
}

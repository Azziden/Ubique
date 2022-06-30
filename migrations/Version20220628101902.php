<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628101902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE salarie_et_entreprise (id INT AUTO_INCREMENT NOT NULL, nom_d_usage VARCHAR(127) NOT NULL, nom_compta VARCHAR(127) NOT NULL, statut VARCHAR(63) DEFAULT NULL, type VARCHAR(63) DEFAULT NULL, droit_auteur DOUBLE PRECISION DEFAULT NULL, abattement_30 VARCHAR(63) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE iconographique DROP FOREIGN KEY FK_1DDA0092B1383DD6');
        $this->addSql('ALTER TABLE redachef DROP FOREIGN KEY FK_B6E2A08DB1383DD6');
        $this->addSql('DROP TABLE salarie_et_entreprise');
    }
}

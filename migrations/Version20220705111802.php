<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705111802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pigiste_client (id INT AUTO_INCREMENT NOT NULL, magazine_id INT DEFAULT NULL, salarie_et_entreprise_id INT DEFAULT NULL, article VARCHAR(63) DEFAULT NULL, signe INT DEFAULT NULL, nb_de_feuillet DOUBLE PRECISION DEFAULT NULL, forfait DOUBLE PRECISION DEFAULT NULL, prix_au_feuillet DOUBLE PRECISION DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, montant_total_brut DOUBLE PRECISION DEFAULT NULL, montant_charge DOUBLE PRECISION DEFAULT NULL, INDEX IDX_4EC0093B3EB84A1D (magazine_id), INDEX IDX_4EC0093BB1383DD6 (salarie_et_entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pigiste_client ADD CONSTRAINT FK_4EC0093B3EB84A1D FOREIGN KEY (magazine_id) REFERENCES magazine (id)');
        $this->addSql('ALTER TABLE pigiste_client ADD CONSTRAINT FK_4EC0093BB1383DD6 FOREIGN KEY (salarie_et_entreprise_id) REFERENCES salarie_et_entreprise (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE pigiste_client');
    }
}

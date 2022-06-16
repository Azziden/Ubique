<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220613124757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE redachef (id INT AUTO_INCREMENT NOT NULL, article VARCHAR(63) NOT NULL, signe INT DEFAULT NULL, nb_de_feuillet DOUBLE PRECISION DEFAULT NULL, forfait DOUBLE PRECISION DEFAULT NULL, prix_au_feuillet DOUBLE PRECISION DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salarie_et_entreprise (id INT AUTO_INCREMENT NOT NULL, nom_d_usage VARCHAR(127) NOT NULL, nom_compta VARCHAR(127) NOT NULL, statut VARCHAR(63) NOT NULL, type VARCHAR(63) NOT NULL, droit_auteur DOUBLE PRECISION DEFAULT NULL, abattement_30 VARCHAR(63) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE titre');
        $this->addSql('DROP INDEX code_affaire ON magazine');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE titre (id INT AUTO_INCREMENT NOT NULL, titre_dans_tableau_direction VARCHAR(127) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, clients VARCHAR(63) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, racine VARCHAR(31) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, racine_en_clair VARCHAR(127) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('DROP TABLE redachef');
        $this->addSql('DROP TABLE salarie_et_entreprise');
        $this->addSql('CREATE FULLTEXT INDEX code_affaire ON magazine (code_affaire, code_affaire_en_clair)');
    }
}

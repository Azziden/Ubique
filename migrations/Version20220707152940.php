<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220707152940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE iconographique (id INT AUTO_INCREMENT NOT NULL, magazine_id INT DEFAULT NULL, salarie_et_entreprise_id INT DEFAULT NULL, article VARCHAR(127) DEFAULT NULL, nb_photo INT NOT NULL, prix_photo INT NOT NULL, montant DOUBLE PRECISION NOT NULL, INDEX IDX_1DDA00923EB84A1D (magazine_id), INDEX IDX_1DDA0092B1383DD6 (salarie_et_entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE magazine (id INT AUTO_INCREMENT NOT NULL, titre_id INT DEFAULT NULL, code_affaire VARCHAR(63) NOT NULL, code_affaire_en_clair VARCHAR(255) NOT NULL, date_de_bouclage VARCHAR(255) DEFAULT NULL, date_de_parution VARCHAR(255) DEFAULT NULL, titre_en_clair VARCHAR(127) DEFAULT NULL, nb_de_page_redactionnelle DOUBLE PRECISION DEFAULT NULL, INDEX IDX_378C2FE4D54FAE5E (titre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pigiste_client (id INT AUTO_INCREMENT NOT NULL, magazine_id INT DEFAULT NULL, salarie_et_entreprise_id INT DEFAULT NULL, article VARCHAR(63) DEFAULT NULL, signe INT DEFAULT NULL, nb_de_feuillet DOUBLE PRECISION DEFAULT NULL, forfait DOUBLE PRECISION DEFAULT NULL, prix_au_feuillet DOUBLE PRECISION DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, montant_total_brut DOUBLE PRECISION DEFAULT NULL, montant_charge DOUBLE PRECISION DEFAULT NULL, INDEX IDX_4EC0093B3EB84A1D (magazine_id), INDEX IDX_4EC0093BB1383DD6 (salarie_et_entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE redachef (id INT AUTO_INCREMENT NOT NULL, magazine_id INT DEFAULT NULL, salarie_et_entreprise_id INT DEFAULT NULL, article VARCHAR(63) DEFAULT NULL, signe INT DEFAULT NULL, nb_de_feuillet DOUBLE PRECISION DEFAULT NULL, forfait DOUBLE PRECISION DEFAULT NULL, prix_au_feuillet DOUBLE PRECISION DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, montant_total_brut DOUBLE PRECISION DEFAULT NULL, montant_charge DOUBLE PRECISION DEFAULT NULL, INDEX IDX_B6E2A08D3EB84A1D (magazine_id), INDEX IDX_B6E2A08DB1383DD6 (salarie_et_entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salarie_et_entreprise (id INT AUTO_INCREMENT NOT NULL, nom_d_usage VARCHAR(127) NOT NULL, nom_compta VARCHAR(127) NOT NULL, statut VARCHAR(63) DEFAULT NULL, type VARCHAR(63) DEFAULT NULL, droit_auteur DOUBLE PRECISION DEFAULT NULL, abattement_30 VARCHAR(63) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE titre (id INT AUTO_INCREMENT NOT NULL, titre_dans_tableau_direction VARCHAR(127) NOT NULL, clients VARCHAR(63) NOT NULL, racine VARCHAR(15) NOT NULL, racine_en_clair VARCHAR(127) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, pseudonym VARCHAR(255) DEFAULT NULL, username VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, reset_token VARCHAR(100) DEFAULT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE iconographique ADD CONSTRAINT FK_1DDA00923EB84A1D FOREIGN KEY (magazine_id) REFERENCES magazine (id)');
        $this->addSql('ALTER TABLE iconographique ADD CONSTRAINT FK_1DDA0092B1383DD6 FOREIGN KEY (salarie_et_entreprise_id) REFERENCES salarie_et_entreprise (id)');
        $this->addSql('ALTER TABLE magazine ADD CONSTRAINT FK_378C2FE4D54FAE5E FOREIGN KEY (titre_id) REFERENCES titre (id)');
        $this->addSql('ALTER TABLE pigiste_client ADD CONSTRAINT FK_4EC0093B3EB84A1D FOREIGN KEY (magazine_id) REFERENCES magazine (id)');
        $this->addSql('ALTER TABLE pigiste_client ADD CONSTRAINT FK_4EC0093BB1383DD6 FOREIGN KEY (salarie_et_entreprise_id) REFERENCES salarie_et_entreprise (id)');
        $this->addSql('ALTER TABLE redachef ADD CONSTRAINT FK_B6E2A08D3EB84A1D FOREIGN KEY (magazine_id) REFERENCES magazine (id)');
        $this->addSql('ALTER TABLE redachef ADD CONSTRAINT FK_B6E2A08DB1383DD6 FOREIGN KEY (salarie_et_entreprise_id) REFERENCES salarie_et_entreprise (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE iconographique DROP FOREIGN KEY FK_1DDA00923EB84A1D');
        $this->addSql('ALTER TABLE pigiste_client DROP FOREIGN KEY FK_4EC0093B3EB84A1D');
        $this->addSql('ALTER TABLE redachef DROP FOREIGN KEY FK_B6E2A08D3EB84A1D');
        $this->addSql('ALTER TABLE iconographique DROP FOREIGN KEY FK_1DDA0092B1383DD6');
        $this->addSql('ALTER TABLE pigiste_client DROP FOREIGN KEY FK_4EC0093BB1383DD6');
        $this->addSql('ALTER TABLE redachef DROP FOREIGN KEY FK_B6E2A08DB1383DD6');
        $this->addSql('ALTER TABLE magazine DROP FOREIGN KEY FK_378C2FE4D54FAE5E');
        $this->addSql('DROP TABLE iconographique');
        $this->addSql('DROP TABLE magazine');
        $this->addSql('DROP TABLE pigiste_client');
        $this->addSql('DROP TABLE redachef');
        $this->addSql('DROP TABLE salarie_et_entreprise');
        $this->addSql('DROP TABLE titre');
        $this->addSql('DROP TABLE `user`');
    }
}

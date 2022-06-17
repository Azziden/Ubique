<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220617085129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE titre (id INT AUTO_INCREMENT NOT NULL, titre_dans_tableau_direction VARCHAR(127) NOT NULL, clients VARCHAR(63) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE iconographique ADD CONSTRAINT FK_1DDA00923EB84A1D FOREIGN KEY (magazine_id) REFERENCES magazine (id)');
        $this->addSql('ALTER TABLE iconographique ADD CONSTRAINT FK_1DDA0092B1383DD6 FOREIGN KEY (salarie_et_entreprise_id) REFERENCES salarie_et_entreprise (id)');
        $this->addSql('ALTER TABLE magazine ADD titre_id INT NOT NULL, CHANGE nb_de_page_redactionnelle nb_de_page_redactionnelle DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE magazine ADD CONSTRAINT FK_378C2FE4D54FAE5E FOREIGN KEY (titre_id) REFERENCES titre (id)');
        $this->addSql('CREATE INDEX IDX_378C2FE4D54FAE5E ON magazine (titre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE magazine DROP FOREIGN KEY FK_378C2FE4D54FAE5E');
        $this->addSql('DROP TABLE titre');
        $this->addSql('ALTER TABLE iconographique DROP FOREIGN KEY FK_1DDA00923EB84A1D');
        $this->addSql('ALTER TABLE iconographique DROP FOREIGN KEY FK_1DDA0092B1383DD6');
        $this->addSql('DROP INDEX IDX_378C2FE4D54FAE5E ON magazine');
        $this->addSql('ALTER TABLE magazine DROP titre_id, CHANGE nb_de_page_redactionnelle nb_de_page_redactionnelle INT DEFAULT NULL');
    }
}

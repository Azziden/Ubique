<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220614093213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE iconographique (id INT AUTO_INCREMENT NOT NULL, magazine_id INT NOT NULL, salarie_et_entreprise_id INT NOT NULL, article VARCHAR(127) DEFAULT NULL, nb_photo INT NOT NULL, prix_photo INT NOT NULL, montant DOUBLE PRECISION NOT NULL, INDEX IDX_1DDA00923EB84A1D (magazine_id), UNIQUE INDEX UNIQ_1DDA0092B1383DD6 (salarie_et_entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE iconographique ADD CONSTRAINT FK_1DDA00923EB84A1D FOREIGN KEY (magazine_id) REFERENCES magazine (id)');
        $this->addSql('ALTER TABLE iconographique ADD CONSTRAINT FK_1DDA0092B1383DD6 FOREIGN KEY (salarie_et_entreprise_id) REFERENCES salarie_et_entreprise (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE iconographique');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220616093905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE iconographique ADD CONSTRAINT FK_1DDA00923EB84A1D FOREIGN KEY (magazine_id) REFERENCES magazine (id)');
        $this->addSql('ALTER TABLE iconographique ADD CONSTRAINT FK_1DDA0092B1383DD6 FOREIGN KEY (salarie_et_entreprise_id) REFERENCES salarie_et_entreprise (id)');
        $this->addSql('ALTER TABLE magazine ADD nb_de_page_redactionnelle DOUBLE PRECISION DEFAULT NULL, DROP nb_de_page_redactionelle');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE iconographique DROP FOREIGN KEY FK_1DDA00923EB84A1D');
        $this->addSql('ALTER TABLE iconographique DROP FOREIGN KEY FK_1DDA0092B1383DD6');
        $this->addSql('ALTER TABLE magazine ADD nb_de_page_redactionelle INT DEFAULT NULL, DROP nb_de_page_redactionnelle');
    }
}

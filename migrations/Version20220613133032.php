<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220613133032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE redachef DROP FOREIGN KEY FK_B6E2A08DADAF7C23');
        $this->addSql('ALTER TABLE redachef DROP FOREIGN KEY FK_B6E2A08DBD93691C');
        $this->addSql('DROP INDEX IDX_B6E2A08DBD93691C ON redachef');
        $this->addSql('DROP INDEX UNIQ_B6E2A08DADAF7C23 ON redachef');
        $this->addSql('ALTER TABLE redachef ADD salarie_et_entreprise_id INT NOT NULL, ADD magazine_id INT NOT NULL, DROP salarie_et_entreprise_id_id, DROP magazine_id_id');
        $this->addSql('ALTER TABLE redachef ADD CONSTRAINT FK_B6E2A08DB1383DD6 FOREIGN KEY (salarie_et_entreprise_id) REFERENCES salarie_et_entreprise (id)');
        $this->addSql('ALTER TABLE redachef ADD CONSTRAINT FK_B6E2A08D3EB84A1D FOREIGN KEY (magazine_id) REFERENCES magazine (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6E2A08DB1383DD6 ON redachef (salarie_et_entreprise_id)');
        $this->addSql('CREATE INDEX IDX_B6E2A08D3EB84A1D ON redachef (magazine_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE redachef DROP FOREIGN KEY FK_B6E2A08DB1383DD6');
        $this->addSql('ALTER TABLE redachef DROP FOREIGN KEY FK_B6E2A08D3EB84A1D');
        $this->addSql('DROP INDEX UNIQ_B6E2A08DB1383DD6 ON redachef');
        $this->addSql('DROP INDEX IDX_B6E2A08D3EB84A1D ON redachef');
        $this->addSql('ALTER TABLE redachef ADD salarie_et_entreprise INT NOT NULL, ADD magazine INT NOT NULL, DROP salarie_et_entreprise, DROP magazine');
        $this->addSql('ALTER TABLE redachef ADD CONSTRAINT FK_B6E2A08DADAF7C23 FOREIGN KEY (salarie_et_entreprise) REFERENCES salarie_et_entreprise (id)');
        $this->addSql('ALTER TABLE redachef ADD CONSTRAINT FK_B6E2A08DBD93691C FOREIGN KEY (magazine) REFERENCES magazine (id)');
        $this->addSql('CREATE INDEX IDX_B6E2A08DBD93691C ON redachef (magazine)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6E2A08DADAF7C23 ON redachef (salarie_et_entreprise)');
    }
}

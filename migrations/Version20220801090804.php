<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220801090804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE titre_membership (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, titre_id INT NOT NULL, INDEX IDX_C4099BDFA76ED395 (user_id), INDEX IDX_C4099BDFD54FAE5E (titre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE titre_membership ADD CONSTRAINT FK_C4099BDFA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE titre_membership ADD CONSTRAINT FK_C4099BDFD54FAE5E FOREIGN KEY (titre_id) REFERENCES titre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE titre_membership');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200827033548 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE livrable_attendu_apprenant (id INT AUTO_INCREMENT NOT NULL, apprenants_id INT DEFAULT NULL, livrable_attendus_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_BDB84E34D4B7C9BD (apprenants_id), INDEX IDX_BDB84E3475D62BB4 (livrable_attendus_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE livrable_attendu_apprenant ADD CONSTRAINT FK_BDB84E34D4B7C9BD FOREIGN KEY (apprenants_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE livrable_attendu_apprenant ADD CONSTRAINT FK_BDB84E3475D62BB4 FOREIGN KEY (livrable_attendus_id) REFERENCES livrable_attendu (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE livrable_attendu_apprenant');
    }
}

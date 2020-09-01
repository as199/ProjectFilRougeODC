<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200829165420 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brief_apprenant ADD briefs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE brief_apprenant ADD CONSTRAINT FK_DD6198EDCA062D03 FOREIGN KEY (briefs_id) REFERENCES brief_apprenant (id)');
        $this->addSql('CREATE INDEX IDX_DD6198EDCA062D03 ON brief_apprenant (briefs_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brief_apprenant DROP FOREIGN KEY FK_DD6198EDCA062D03');
        $this->addSql('DROP INDEX IDX_DD6198EDCA062D03 ON brief_apprenant');
        $this->addSql('ALTER TABLE brief_apprenant DROP briefs_id');
    }
}

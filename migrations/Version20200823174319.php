<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200823174319 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE profil_sorti_apprenant');
        $this->addSql('DROP TABLE promo_profil_sorti');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profil_sorti_apprenant (profil_sorti_id INT NOT NULL, apprenant_id INT NOT NULL, INDEX IDX_E4A3BF04B37C4ED5 (profil_sorti_id), INDEX IDX_E4A3BF04C5697D6D (apprenant_id), PRIMARY KEY(profil_sorti_id, apprenant_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE promo_profil_sorti (promo_id INT NOT NULL, profil_sorti_id INT NOT NULL, INDEX IDX_E5574F34D0C07AFF (promo_id), INDEX IDX_E5574F34B37C4ED5 (profil_sorti_id), PRIMARY KEY(promo_id, profil_sorti_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE profil_sorti_apprenant ADD CONSTRAINT FK_E4A3BF04B37C4ED5 FOREIGN KEY (profil_sorti_id) REFERENCES profil_sorti (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profil_sorti_apprenant ADD CONSTRAINT FK_E4A3BF04C5697D6D FOREIGN KEY (apprenant_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_profil_sorti ADD CONSTRAINT FK_E5574F34B37C4ED5 FOREIGN KEY (profil_sorti_id) REFERENCES profil_sorti (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_profil_sorti ADD CONSTRAINT FK_E5574F34D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
    }
}

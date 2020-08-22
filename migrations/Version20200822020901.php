<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200822020901 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brief_niveau (brief_id INT NOT NULL, niveau_id INT NOT NULL, INDEX IDX_1BF05631757FABFF (brief_id), INDEX IDX_1BF05631B3E9C81 (niveau_id), PRIMARY KEY(brief_id, niveau_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence_valides (id INT AUTO_INCREMENT NOT NULL, competences_id INT DEFAULT NULL, referenciels_id INT DEFAULT NULL, apprenants_id INT DEFAULT NULL, promos_id INT DEFAULT NULL, INDEX IDX_4180A7E7A660B158 (competences_id), INDEX IDX_4180A7E7CE8A50AE (referenciels_id), INDEX IDX_4180A7E7D4B7C9BD (apprenants_id), INDEX IDX_4180A7E7CAA392D2 (promos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau_livrable_partiel (niveau_id INT NOT NULL, livrable_partiel_id INT NOT NULL, INDEX IDX_681AB572B3E9C81 (niveau_id), INDEX IDX_681AB572519178C4 (livrable_partiel_id), PRIMARY KEY(niveau_id, livrable_partiel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE brief_niveau ADD CONSTRAINT FK_1BF05631757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brief_niveau ADD CONSTRAINT FK_1BF05631B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competence_valides ADD CONSTRAINT FK_4180A7E7A660B158 FOREIGN KEY (competences_id) REFERENCES competence (id)');
        $this->addSql('ALTER TABLE competence_valides ADD CONSTRAINT FK_4180A7E7CE8A50AE FOREIGN KEY (referenciels_id) REFERENCES referenciel (id)');
        $this->addSql('ALTER TABLE competence_valides ADD CONSTRAINT FK_4180A7E7D4B7C9BD FOREIGN KEY (apprenants_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE competence_valides ADD CONSTRAINT FK_4180A7E7CAA392D2 FOREIGN KEY (promos_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE niveau_livrable_partiel ADD CONSTRAINT FK_681AB572B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau_livrable_partiel ADD CONSTRAINT FK_681AB572519178C4 FOREIGN KEY (livrable_partiel_id) REFERENCES livrable_partiel (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE referentiel');
        $this->addSql('ALTER TABLE apprenant_livrable_partiel ADD livrable_partiels_id INT DEFAULT NULL, ADD apprenants_id INT DEFAULT NULL, ADD fil_de_discussions_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE apprenant_livrable_partiel ADD CONSTRAINT FK_8572D6AD7B292AF4 FOREIGN KEY (livrable_partiels_id) REFERENCES livrable_partiel (id)');
        $this->addSql('ALTER TABLE apprenant_livrable_partiel ADD CONSTRAINT FK_8572D6ADD4B7C9BD FOREIGN KEY (apprenants_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE apprenant_livrable_partiel ADD CONSTRAINT FK_8572D6AD2F388AFA FOREIGN KEY (fil_de_discussions_id) REFERENCES fil_de_discussion (id)');
        $this->addSql('CREATE INDEX IDX_8572D6AD7B292AF4 ON apprenant_livrable_partiel (livrable_partiels_id)');
        $this->addSql('CREATE INDEX IDX_8572D6ADD4B7C9BD ON apprenant_livrable_partiel (apprenants_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8572D6AD2F388AFA ON apprenant_livrable_partiel (fil_de_discussions_id)');
        $this->addSql('ALTER TABLE brief ADD formateurs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE brief ADD CONSTRAINT FK_1FBB1007FB0881C8 FOREIGN KEY (formateurs_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1FBB1007FB0881C8 ON brief (formateurs_id)');
        $this->addSql('ALTER TABLE brief_livrable ADD briefs_id INT DEFAULT NULL, ADD livrables_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE brief_livrable ADD CONSTRAINT FK_7890B21ACA062D03 FOREIGN KEY (briefs_id) REFERENCES brief (id)');
        $this->addSql('ALTER TABLE brief_livrable ADD CONSTRAINT FK_7890B21A96108872 FOREIGN KEY (livrables_id) REFERENCES livrable (id)');
        $this->addSql('CREATE INDEX IDX_7890B21ACA062D03 ON brief_livrable (briefs_id)');
        $this->addSql('CREATE INDEX IDX_7890B21A96108872 ON brief_livrable (livrables_id)');
        $this->addSql('ALTER TABLE brief_ma_promo ADD briefs_id INT DEFAULT NULL, ADD promos_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE brief_ma_promo ADD CONSTRAINT FK_6E0C4800CA062D03 FOREIGN KEY (briefs_id) REFERENCES brief (id)');
        $this->addSql('ALTER TABLE brief_ma_promo ADD CONSTRAINT FK_6E0C4800CAA392D2 FOREIGN KEY (promos_id) REFERENCES promo (id)');
        $this->addSql('CREATE INDEX IDX_6E0C4800CA062D03 ON brief_ma_promo (briefs_id)');
        $this->addSql('CREATE INDEX IDX_6E0C4800CAA392D2 ON brief_ma_promo (promos_id)');
        $this->addSql('ALTER TABLE commentaire ADD fil_de_discussion_id INT DEFAULT NULL, ADD formateurs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC9E665F32 FOREIGN KEY (fil_de_discussion_id) REFERENCES fil_de_discussion (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCFB0881C8 FOREIGN KEY (formateurs_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC9E665F32 ON commentaire (fil_de_discussion_id)');
        $this->addSql('CREATE INDEX IDX_67F068BCFB0881C8 ON commentaire (formateurs_id)');
        $this->addSql('ALTER TABLE livrable_partiel ADD brief_ma_promos_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livrable_partiel ADD CONSTRAINT FK_37F072C5B9F81367 FOREIGN KEY (brief_ma_promos_id) REFERENCES brief_ma_promo (id)');
        $this->addSql('CREATE INDEX IDX_37F072C5B9F81367 ON livrable_partiel (brief_ma_promos_id)');
        $this->addSql('ALTER TABLE ressource ADD briefs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F4544CA062D03 FOREIGN KEY (briefs_id) REFERENCES brief (id)');
        $this->addSql('CREATE INDEX IDX_939F4544CA062D03 ON ressource (briefs_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE referentiel (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE brief_niveau');
        $this->addSql('DROP TABLE competence_valides');
        $this->addSql('DROP TABLE niveau_livrable_partiel');
        $this->addSql('ALTER TABLE apprenant_livrable_partiel DROP FOREIGN KEY FK_8572D6AD7B292AF4');
        $this->addSql('ALTER TABLE apprenant_livrable_partiel DROP FOREIGN KEY FK_8572D6ADD4B7C9BD');
        $this->addSql('ALTER TABLE apprenant_livrable_partiel DROP FOREIGN KEY FK_8572D6AD2F388AFA');
        $this->addSql('DROP INDEX IDX_8572D6AD7B292AF4 ON apprenant_livrable_partiel');
        $this->addSql('DROP INDEX IDX_8572D6ADD4B7C9BD ON apprenant_livrable_partiel');
        $this->addSql('DROP INDEX UNIQ_8572D6AD2F388AFA ON apprenant_livrable_partiel');
        $this->addSql('ALTER TABLE apprenant_livrable_partiel DROP livrable_partiels_id, DROP apprenants_id, DROP fil_de_discussions_id');
        $this->addSql('ALTER TABLE brief DROP FOREIGN KEY FK_1FBB1007FB0881C8');
        $this->addSql('DROP INDEX IDX_1FBB1007FB0881C8 ON brief');
        $this->addSql('ALTER TABLE brief DROP formateurs_id');
        $this->addSql('ALTER TABLE brief_livrable DROP FOREIGN KEY FK_7890B21ACA062D03');
        $this->addSql('ALTER TABLE brief_livrable DROP FOREIGN KEY FK_7890B21A96108872');
        $this->addSql('DROP INDEX IDX_7890B21ACA062D03 ON brief_livrable');
        $this->addSql('DROP INDEX IDX_7890B21A96108872 ON brief_livrable');
        $this->addSql('ALTER TABLE brief_livrable DROP briefs_id, DROP livrables_id');
        $this->addSql('ALTER TABLE brief_ma_promo DROP FOREIGN KEY FK_6E0C4800CA062D03');
        $this->addSql('ALTER TABLE brief_ma_promo DROP FOREIGN KEY FK_6E0C4800CAA392D2');
        $this->addSql('DROP INDEX IDX_6E0C4800CA062D03 ON brief_ma_promo');
        $this->addSql('DROP INDEX IDX_6E0C4800CAA392D2 ON brief_ma_promo');
        $this->addSql('ALTER TABLE brief_ma_promo DROP briefs_id, DROP promos_id');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC9E665F32');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCFB0881C8');
        $this->addSql('DROP INDEX IDX_67F068BC9E665F32 ON commentaire');
        $this->addSql('DROP INDEX IDX_67F068BCFB0881C8 ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP fil_de_discussion_id, DROP formateurs_id');
        $this->addSql('ALTER TABLE livrable_partiel DROP FOREIGN KEY FK_37F072C5B9F81367');
        $this->addSql('DROP INDEX IDX_37F072C5B9F81367 ON livrable_partiel');
        $this->addSql('ALTER TABLE livrable_partiel DROP brief_ma_promos_id');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F4544CA062D03');
        $this->addSql('DROP INDEX IDX_939F4544CA062D03 ON ressource');
        $this->addSql('ALTER TABLE ressource DROP briefs_id');
    }
}

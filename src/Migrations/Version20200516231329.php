<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200516231329 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE reponses (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, exo_id INT NOT NULL, note INT NOT NULL, INDEX IDX_1E512EC6DDEAB1A3 (etudiant_id), INDEX IDX_1E512EC6DA1C6F33 (exo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiants (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nom VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_227C02EBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiants_cours (etudiants_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_6B91558BA873A5C6 (etudiants_id), INDEX IDX_6B91558B7ECF78B0 (cours_id), PRIMARY KEY(etudiants_id, cours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exos (id INT AUTO_INCREMENT NOT NULL, cour_id INT NOT NULL, contenu LONGTEXT NOT NULL, titre VARCHAR(255) NOT NULL, INDEX IDX_5C37B62BB7942F03 (cour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instructions (id INT AUTO_INCREMENT NOT NULL, exo_id INT NOT NULL, contenu LONGTEXT NOT NULL, ordre_vrai INT NOT NULL, ordre_faux INT NOT NULL, INDEX IDX_997D812BDA1C6F33 (exo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, prof_id INT NOT NULL, nom VARCHAR(255) NOT NULL, contenu LONGTEXT DEFAULT NULL, INDEX IDX_FDCA8C9CABC1F7FE (prof_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profs (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nom VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_47E61F7FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, type TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reponses ADD CONSTRAINT FK_1E512EC6DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiants (id)');
        $this->addSql('ALTER TABLE reponses ADD CONSTRAINT FK_1E512EC6DA1C6F33 FOREIGN KEY (exo_id) REFERENCES exos (id)');
        $this->addSql('ALTER TABLE etudiants ADD CONSTRAINT FK_227C02EBA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE etudiants_cours ADD CONSTRAINT FK_6B91558BA873A5C6 FOREIGN KEY (etudiants_id) REFERENCES etudiants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiants_cours ADD CONSTRAINT FK_6B91558B7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exos ADD CONSTRAINT FK_5C37B62BB7942F03 FOREIGN KEY (cour_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE instructions ADD CONSTRAINT FK_997D812BDA1C6F33 FOREIGN KEY (exo_id) REFERENCES exos (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CABC1F7FE FOREIGN KEY (prof_id) REFERENCES profs (id)');
        $this->addSql('ALTER TABLE profs ADD CONSTRAINT FK_47E61F7FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reponses DROP FOREIGN KEY FK_1E512EC6DDEAB1A3');
        $this->addSql('ALTER TABLE etudiants_cours DROP FOREIGN KEY FK_6B91558BA873A5C6');
        $this->addSql('ALTER TABLE reponses DROP FOREIGN KEY FK_1E512EC6DA1C6F33');
        $this->addSql('ALTER TABLE instructions DROP FOREIGN KEY FK_997D812BDA1C6F33');
        $this->addSql('ALTER TABLE etudiants_cours DROP FOREIGN KEY FK_6B91558B7ECF78B0');
        $this->addSql('ALTER TABLE exos DROP FOREIGN KEY FK_5C37B62BB7942F03');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CABC1F7FE');
        $this->addSql('ALTER TABLE etudiants DROP FOREIGN KEY FK_227C02EBA76ED395');
        $this->addSql('ALTER TABLE profs DROP FOREIGN KEY FK_47E61F7FA76ED395');
        $this->addSql('DROP TABLE reponses');
        $this->addSql('DROP TABLE etudiants');
        $this->addSql('DROP TABLE etudiants_cours');
        $this->addSql('DROP TABLE exos');
        $this->addSql('DROP TABLE instructions');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE profs');
        $this->addSql('DROP TABLE users');
    }
}

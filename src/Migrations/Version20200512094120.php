<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200512094120 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reponses ADD etudiants_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponses ADD CONSTRAINT FK_1E512EC6A873A5C6 FOREIGN KEY (etudiants_id) REFERENCES etudiants (id)');
        $this->addSql('CREATE INDEX IDX_1E512EC6A873A5C6 ON reponses (etudiants_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reponses DROP FOREIGN KEY FK_1E512EC6A873A5C6');
        $this->addSql('DROP INDEX IDX_1E512EC6A873A5C6 ON reponses');
        $this->addSql('ALTER TABLE reponses DROP etudiants_id');
    }
}

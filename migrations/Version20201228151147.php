<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201228151147 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD creator_id_id INT NOT NULL,ADD CONSTRAINT FK_23A0E66F05788E9 FOREIGN KEY (creator_id_id) REFERENCES user (id), ADD down_load_link VARCHAR(255) NOT NULL, ADD array_tags LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('CREATE INDEX IDX_23A0E66F05788E9 ON article (creator_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66F05788E9');
        $this->addSql('DROP INDEX IDX_23A0E66F05788E9 ON article');
        $this->addSql('ALTER TABLE article DROP creator_id_id, DROP down_load_link, DROP array_tags');
    }
}

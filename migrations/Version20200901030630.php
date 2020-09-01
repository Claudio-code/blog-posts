<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200901030630 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coment ADD post_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE coment ADD CONSTRAINT FK_F86E9D24B89032C FOREIGN KEY (post_id) REFERENCES posts (id)');
        $this->addSql('CREATE INDEX IDX_F86E9D24B89032C ON coment (post_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coment DROP FOREIGN KEY FK_F86E9D24B89032C');
        $this->addSql('DROP INDEX IDX_F86E9D24B89032C ON coment');
        $this->addSql('ALTER TABLE coment DROP post_id');
    }
}

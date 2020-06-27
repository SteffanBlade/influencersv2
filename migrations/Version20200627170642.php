<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200627170642 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles CHANGE author author INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8E0C2A51FE11D138 ON authors (Name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8E0C2A5126535370 ON authors (Email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles CHANGE author author INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_8E0C2A51FE11D138 ON authors');
        $this->addSql('DROP INDEX UNIQ_8E0C2A5126535370 ON authors');
    }
}

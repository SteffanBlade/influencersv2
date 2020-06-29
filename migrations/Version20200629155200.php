<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200629155200 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articles (author INT DEFAULT NULL, Id INT AUTO_INCREMENT NOT NULL, Title VARCHAR(250) NOT NULL, Votes INT NOT NULL, Tags VARCHAR(250) NOT NULL, image VARCHAR(255) NOT NULL, date DATETIME NOT NULL, content MEDIUMTEXT DEFAULT NULL, INDEX articles_fk (author), PRIMARY KEY(Id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE authors (Id INT AUTO_INCREMENT NOT NULL, Name VARCHAR(250) NOT NULL, Email VARCHAR(255) NOT NULL, Votes INT NOT NULL, UNIQUE INDEX UNIQ_8E0C2A51FE11D138 (Name), UNIQUE INDEX UNIQ_8E0C2A5126535370 (Email), PRIMARY KEY(Id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168BDAFD8C8 FOREIGN KEY (author) REFERENCES authors (Id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168BDAFD8C8');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE authors');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200623185639 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articles (Articles_Id INT AUTO_INCREMENT NOT NULL, Articles_Date DATETIME NOT NULL, Articles_Title VARCHAR(250) NOT NULL, Articles_Content MEDIUMTEXT NOT NULL, Articles_Image BLOB NOT NULL, Articles_Edit TINYINT(1) NOT NULL, Articles_Votes INT NOT NULL, Articles_Authors_Id INT DEFAULT NULL, Articles_Tags_Id INT DEFAULT NULL, INDEX Articles_Authors_Id (Articles_Authors_Id), INDEX Articles_Tags_Id (Articles_Tags_Id), PRIMARY KEY(Articles_Id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE authors (Authors_Id INT AUTO_INCREMENT NOT NULL, Authors_Votes INT NOT NULL, Authors_Name VARCHAR(255) NOT NULL, Authors_Email VARCHAR(320) NOT NULL, PRIMARY KEY(Authors_Id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (Tags_Id INT AUTO_INCREMENT NOT NULL, Tag_First VARCHAR(50) DEFAULT NULL, Tag_Second VARCHAR(50) DEFAULT NULL, Tag_Third VARCHAR(50) DEFAULT NULL, PRIMARY KEY(Tags_Id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168754C5C3A FOREIGN KEY (Articles_Authors_Id) REFERENCES authors (Authors_Id)');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD316885184D56 FOREIGN KEY (Articles_Tags_Id) REFERENCES tags (Tags_Id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168754C5C3A');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD316885184D56');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE authors');
        $this->addSql('DROP TABLE tags');
    }
}

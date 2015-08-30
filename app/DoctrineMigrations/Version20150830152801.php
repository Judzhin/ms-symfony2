<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150830152801 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tut_t_authors (id INT AUTO_INCREMENT NOT NULL, createdAt DATETIME NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tut_t_posts (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, createdAt DATETIME NOT NULL, title VARCHAR(150) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_BFD5AE0FF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tut_t_posts ADD CONSTRAINT FK_BFD5AE0FF675F31B FOREIGN KEY (author_id) REFERENCES tut_t_authors (id)');
        $this->addSql('DROP TABLE cnt_t_posts');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tut_t_posts DROP FOREIGN KEY FK_BFD5AE0FF675F31B');
        $this->addSql('CREATE TABLE cnt_t_posts (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, description VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, text LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, published TINYINT(1) DEFAULT NULL, createdat DATETIME NOT NULL, modifiedat DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE tut_t_authors');
        $this->addSql('DROP TABLE tut_t_posts');
    }
}

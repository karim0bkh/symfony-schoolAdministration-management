<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221228001019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE words_document DROP FOREIGN KEY FK_523870DB749B15FB');
        $this->addSql('ALTER TABLE words_document DROP FOREIGN KEY FK_523870DBC33F7837');
        $this->addSql('DROP TABLE words');
        $this->addSql('DROP TABLE words_document');
        $this->addSql('ALTER TABLE document ADD key_w2 VARCHAR(255) NOT NULL, ADD key_w3 VARCHAR(255) DEFAULT NULL, ADD key_w4 VARCHAR(255) DEFAULT NULL, ADD key_w5 VARCHAR(255) DEFAULT NULL, CHANGE key_w key_w1 VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE words (id INT AUTO_INCREMENT NOT NULL, word VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE words_document (words_id INT NOT NULL, document_id INT NOT NULL, INDEX IDX_523870DBC33F7837 (document_id), INDEX IDX_523870DB749B15FB (words_id), PRIMARY KEY(words_id, document_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE words_document ADD CONSTRAINT FK_523870DB749B15FB FOREIGN KEY (words_id) REFERENCES words (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE words_document ADD CONSTRAINT FK_523870DBC33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE document ADD key_w VARCHAR(255) NOT NULL, DROP key_w1, DROP key_w2, DROP key_w3, DROP key_w4, DROP key_w5');
    }
}

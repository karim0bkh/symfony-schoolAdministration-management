<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221228002437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document ADD keyword1 VARCHAR(255) NOT NULL, ADD keyword2 VARCHAR(255) NOT NULL, ADD keyword3 VARCHAR(255) DEFAULT NULL, ADD keyword4 VARCHAR(255) DEFAULT NULL, ADD keyword5 VARCHAR(255) DEFAULT NULL, DROP key_w1, DROP key_w2, DROP key_w3, DROP key_w4, DROP key_w5');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document ADD key_w1 VARCHAR(255) NOT NULL, ADD key_w2 VARCHAR(255) NOT NULL, ADD key_w3 VARCHAR(255) DEFAULT NULL, ADD key_w4 VARCHAR(255) DEFAULT NULL, ADD key_w5 VARCHAR(255) DEFAULT NULL, DROP keyword1, DROP keyword2, DROP keyword3, DROP keyword4, DROP keyword5');
    }
}

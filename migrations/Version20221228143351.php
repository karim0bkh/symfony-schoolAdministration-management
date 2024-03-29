<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221228143351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_2694D7A5A76ED395 ON demande (user_id)');
        $this->addSql('ALTER TABLE depot ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBCA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_47948BBCA76ED395 ON depot (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5A76ED395');
        $this->addSql('DROP INDEX IDX_2694D7A5A76ED395 ON demande');
        $this->addSql('ALTER TABLE demande DROP user_id');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBCA76ED395');
        $this->addSql('DROP INDEX IDX_47948BBCA76ED395 ON depot');
        $this->addSql('ALTER TABLE depot DROP user_id');
    }
}

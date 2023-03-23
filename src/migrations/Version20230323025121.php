<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230323025121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notification_message (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(50) NOT NULL, unique_id VARCHAR(255) NOT NULL, user_id VARCHAR(255) NOT NULL, recipient VARCHAR(100) NOT NULL, message_text VARCHAR(500) NOT NULL, is_sent TINYINT(1) DEFAULT 0 NOT NULL, created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_A3A3BAC8E3C68343 (unique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE notification_message');
    }
}

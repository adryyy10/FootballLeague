<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231018141117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE club DROP INDEX FK_B8EE38723C105692, ADD UNIQUE INDEX UNIQ_B8EE38727E860E36 (stadium_id)');
        $this->addSql('ALTER TABLE club DROP INDEX FK_B8EE38723C105682, ADD UNIQUE INDEX UNIQ_B8EE3872E48E9A13 (logo)');
        $this->addSql('ALTER TABLE club ADD website VARCHAR(50) NOT NULL, CHANGE palette palette VARCHAR(50) NOT NULL, CHANGE facebook facebook VARCHAR(50) NOT NULL, CHANGE twitter twitter VARCHAR(50) NOT NULL, CHANGE youtube youtube VARCHAR(50) NOT NULL, CHANGE instagram instagram VARCHAR(50) NOT NULL, CHANGE slug slug VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE player DROP club');
        $this->addSql('ALTER TABLE stadium CHANGE img img VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE available_at available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE club DROP INDEX UNIQ_B8EE38727E860E36, ADD INDEX FK_B8EE38723C105692 (stadium_id)');
        $this->addSql('ALTER TABLE club DROP INDEX UNIQ_B8EE3872E48E9A13, ADD INDEX FK_B8EE38723C105682 (logo)');
        $this->addSql('ALTER TABLE club DROP website, CHANGE palette palette INT DEFAULT NULL, CHANGE facebook facebook VARCHAR(50) DEFAULT NULL, CHANGE twitter twitter VARCHAR(50) DEFAULT NULL, CHANGE youtube youtube VARCHAR(50) DEFAULT NULL, CHANGE instagram instagram VARCHAR(50) DEFAULT NULL, CHANGE slug slug VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE stadium CHANGE img img VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE player ADD club VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE created_at created_at DATETIME NOT NULL, CHANGE available_at available_at DATETIME NOT NULL, CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }
}

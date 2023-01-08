<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230107094530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add socials to club';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE club ADD facebook VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE club ADD twitter VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE club ADD youtube VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE club ADD instagram VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE club DROP facebook, twitter, youtube, instagram');
    }
}
